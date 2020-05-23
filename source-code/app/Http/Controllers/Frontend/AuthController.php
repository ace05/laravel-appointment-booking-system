<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\City;
use App\Models\Country;
use App\Utils\UserTypes;
use App\Models\UserLogin;
use App\Models\UserProfile;
use App\Traits\SMSService;
use App\Traits\EmailService;
use App\Utils\EmailTemplate;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Http\Requests\Register;
use App\Models\ServiceSubCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfessionalRegister;
use App\Http\Requests\ServiceProviderRegister;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers, EmailService, SMSService;

    public $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }    

    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function showRegisterForm(Country $countryModel)
    {
        $country = $countryModel->find(config('settings.site_country'));
        $countryCode = null;
        $countryExt = null;
        if(empty($country->iso) === false){
            $countryCode = $country->iso;
            $countryExt = $country->phone_prefix;
        }
        return view('frontend.auth.register', [
            'countryCode' => $countryCode,
            'countryExt' => $countryExt
        ]);
    }

    public function username()
    {
        return 'login';
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required|string',
        ]);
    }

    protected function credentials(Request $request)
    {
        $login = $request->get('login');
        $data = [
            'mobile' => $login,
            'password' => $request->get('password')
        ];
        if(filter_var($login, FILTER_VALIDATE_EMAIL)) {
             $data = [
                'email' => $login,
                'password' => $request->get('password')
            ];
        }

        return $data;
    }

    protected function authenticated(Request $request, $user)
    {
        $login = UserLogin::create([
            'user_id' => $user->id,
            'user_agent' => $request->header('User-Agent'),
            'ip_address' => $request->ip()
        ]);

        if($user->user_type_id != UserTypes::ADMIN){            
            if(empty($user->is_mobile_verified) === true){
                Auth::logout();
                return redirect()->route('site.otp.resend', ['code' => $user->otp_verification_token])->with('error', __('message_mobile_not_verified'));
            }
            if(empty($user->is_email_verified) === true){
                Auth::logout();
                return redirect()->route('site.email.activation.resend')->with('error', __('message_email_activation_code_expired'));
            }
        }


        return redirect()->intended('/');
    }

    public function register(Register $request, User $userModel, UserLogin $loginModel)
    {
        $data = $request->all();
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'mobile' => $data['mobile_number'],
            'user_type_id' => UserTypes::USER,
            'password' => Hash::make($data['password']),
            'user_agent' => $request->header('User-Agent'),
            'ip' => $request->ip(),
            'otp_verification_token' => md5(uniqid(rand(), true))
        ];

        $emailVerificationRequired = empty(config('settings.email_verification')) === false && config('settings.email_verification') == 'Yes' ? true : false;
        if($emailVerificationRequired){
            $userData['email_verification_token'] = md5(uniqid(rand(), true));
            $userData['email_verification_date'] = Carbon::now();
        }
        else{
            $userData['is_email_verified'] = true;
        }

        $otp = generateOtp();
        $userData['otp_code'] = $otp;
        $user = $userModel->create($userData);
        if(empty($user->id) === false){
            if($this->sendSMS(
                $user->mobile, 'otp-verification', [
                    '##OTP##' => $user->otp_code
                ]
            )){
                return redirect()->route('site.otp.verify', ['code' => $user->otp_verification_token])->with('success', __('message_account_creation_success'));
                
            }
            else{
                return redirect()->back()->with(
                    'error', __('message_account_creation_otp_failed')
                );
            }
        }

        return redirect()->back()->with(
            'error', __('message_account_creation_failed')
        );
    }

    public function activateEmail($code, Request $request, User $userModel)
    {
        $user = $userModel->where('email_verification_token', '=', $code)
                        ->first();
        if(empty($user->id) === true){
            return redirect()->route('site.login')->with(
                'error', __('message_email_activation_code_not_exists')
            );
        }

        $date = Carbon::parse($user->email_verification_date);
        $now = Carbon::now();
        if($date->diffInHours($now) > config('site.email_activation_expiry')){
            return redirect()->route('site.email.activation.resend')->with(
                'error', __('message_email_activation_code_expired')
            );
        }

        $user->email_verification_token = null;
        $user->email_verification_date = null;
        $user->is_email_verified = true;
        if($user->save()){
            return redirect()->route('site.login')->with(
                'success', __('message_email_activation_success')
            );
        }

        return redirect()->route('site.login')->with(
                'error', __('message_email_activation_failed')
            );
    }

    public function resendEmailActivation(Request $request)
    {
        return view('frontend.auth.resend_email_activation');
    }

    public function resendActivationEmail(Request $request, User $userModel)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users'
        ]);

        $user = $userModel->where('email', '=', $request->get('email'))
                        ->where('is_email_verified', '=', false)
                        ->whereNotNull('email_verification_token')
                        ->first();

        if(empty($user->id) === true){
            return redirect()->route('site.login')->with(
                'error', __('message_email_activation_already_completed')
            );
        }

        $user->email_verification_date = Carbon::now();
        if($user->save()){
            $this->sendEmail($user->email, EmailTemplate::ACTIVATION, [
                '##ACTIVATION_URL##' => route('site.email.activation', [
                    'code' => $user->email_verification_token
                ]),
                "##NAME##" => $user->getName()
            ]);

            return redirect()->back()->with(
                'success', __('message_email_activation_email_sent')
            );
        }

        return redirect()->back()->with(
            'error', __('message_email_activation_email_send_failed')
        );
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect()->route('site.login');
    }

    public function getPartnerPage(Request $request)
    {
        return view('frontend.auth.partner_page');
    }

    public function professionalSignup(
        Request $request, Country $countryModel, City $cityModel,
        ServiceSubCategory $serviceCategoryModel
    )
    {
        $country = $countryModel->find(config('settings.site_country'));
        $countryCode = null;
        $countryExt = null;
        if(empty($country->iso) === false){
            $countryCode = $country->iso;
            $countryExt = $country->phone_prefix;
        }

        $cities = $cityModel->where('is_active', '=', true)
                        ->pluck('name', 'id')
                        ->toArray();
        $subCategories = $serviceCategoryModel->where('is_active', '=', true)
                            ->pluck('name', 'id')
                            ->toArray();
        return view('frontend.auth.professional_signup', [
            'countryCode' => $countryCode,
            'countryExt' => $countryExt,
            'cities' => $cities,
            'subCategories' => $subCategories
        ]);
    }

    public function registerServiceProviderForm(
        Request $request, Country $countryModel, City $cityModel,
        ServiceSubCategory $serviceCategoryModel
    )
    {
        $country = $countryModel->find(config('settings.site_country'));
        $countryCode = null;
        $countryExt = null;
        if(empty($country->iso) === false){
            $countryCode = $country->iso;
            $countryExt = $country->phone_prefix;
        }

        $cities = $cityModel->where('is_active', '=', true)
                        ->pluck('name', 'id')
                        ->toArray();
        $subCategories = $serviceCategoryModel->where('is_active', '=', true)
                            ->pluck('name', 'id')
                            ->toArray();
        return view('frontend.auth.service_provider_signup', [
            'countryCode' => $countryCode,
            'countryExt' => $countryExt,
            'cities' => $cities,
            'subCategories' => $subCategories
        ]);
    }

    public function registerServiceProvider(
        ServiceProviderRegister $request, User $userModel, ServiceProvider $providerModel
    )
    {
        $data = $request->all();
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'mobile' => $data['mobile_number'],
            'user_type_id' => UserTypes::SERVICE_PROVIDER,
            'password' => Hash::make($data['password']),
            'user_agent' => $request->header('User-Agent'),
            'ip' => $request->ip(),
            'otp_verification_token' => md5(uniqid(rand(), true))
        ];

        $emailVerificationRequired = empty(config('settings.email_verification')) === false && config('settings.email_verification') == 'Yes' ? true : false;
        if($emailVerificationRequired){
            $userData['email_verification_token'] = md5(uniqid(rand(), true));
            $userData['email_verification_date'] = Carbon::now();
        }
        else{
            $userData['is_email_verified'] = true;
        }

        $otp = generateOtp();
        $userData['otp_code'] = $otp;
        $user = $userModel->create($userData);
        if(empty($user->id) === false){
            $providerProfile = $providerModel->create([
                'user_id' => $user->id,
                'name' => $data['service_provider_name'],
                'about' => $data['about']
            ]);

            $user->professions()->attach($data['profession']);
            $user->cities()->attach($data['city_id']);

            if($this->sendSMS(
                $user->mobile, 'otp-verification', [
                    '##OTP##' => $user->otp_code
                ]
            )){
                return redirect()->route('site.otp.verify', ['code' => $user->otp_verification_token])->with('success', __('message_account_creation_success'));
                
            }
            else{
                return redirect()->back()->with(
                    'error', __('message_account_creation_otp_failed')
                );
            }
        }

        return redirect()->back()->with(
            'error', __('message_language_account_creation_failed')
        );
    }

    public function registerProfessional(
        ProfessionalRegister $request, User $userModel, UserProfile $profileModel
    )
    {
        $data = $request->all();
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'mobile' => $data['mobile_number'],
            'user_type_id' => UserTypes::PROFESSIONAL,
            'password' => Hash::make($data['password']),
            'user_agent' => $request->header('User-Agent'),
            'ip' => $request->ip(),
            'otp_verification_token' => md5(uniqid(rand(), true))
        ];

        $emailVerificationRequired = empty(config('settings.email_verification')) === false && config('settings.email_verification') == 'Yes' ? true : false;
        if($emailVerificationRequired){
            $userData['email_verification_token'] = md5(uniqid(rand(), true));
            $userData['email_verification_date'] = Carbon::now();
        }
        else{
            $userData['is_email_verified'] = true;
        }

        $otp = generateOtp();
        $userData['otp_code'] = $otp;
        $user = $userModel->create($userData);
        if(empty($user->id) === false){
            $profile = $profileModel->create([
                'user_id' => $user->id,
                'gender' => $data['gender'],
                'about' => $data['about']
            ]);

            $user->professions()->attach([$data['profession']]);
            $user->cities()->attach([$data['city_id']]);

            if($this->sendSMS(
                $user->mobile, 'otp-verification', [
                    '##OTP##' => $user->otp_code
                ]
            )){
                return redirect()->route('site.otp.verify', ['code' => $user->otp_verification_token])->with('success', __('message_account_creation_success'));
                
            }
            else{
                return redirect()->back()->with(
                    'error', __('message_account_creation_otp_failed')
                );
            }
        }

        return redirect()->back()->with(
            'error', __('message_language_account_creation_failed')
        );
    }

    public function verifyOtpForm($code, Request $request, User $userModel)
    {
        $user = $userModel->where('otp_verification_token', '=', $code)
                        ->where('is_mobile_verified', '=', false)
                        ->first();
        if(empty($user->id) === true){
            return redirect()->route('site.login')->with(
                'error', __('message_mobile_already_verified')
            );
        }

        return view('frontend.auth.otp_verify', ['user' => $user]);

    }

    public function resendOtpForm($code, Request $request, User $userModel, Country $countryModel)
    {
        $user = $userModel->where('otp_verification_token', '=', $code)
                        ->where('is_mobile_verified', '=', false)
                        ->first();
        if(empty($user->id) === true){
            return redirect()->route('site.login')->with(
                'error', __('message_mobile_already_verified')
            );
        }

        $country = $countryModel->find(config('settings.site_country'));
        $countryCode = null;
        $countryExt = null;
        if(empty($country->iso) === false){
            $countryCode = $country->iso;
            $countryExt = $country->phone_prefix;
        }

        return view('frontend.auth.otp_resend_form', [
            'user' => $user,
            'countryExt' => $countryExt,
            'countryCode' => $countryCode
        ]);
    }

    public function resendOtp(
        $code, Request $request, User $userModel, Country $countryModel
    )
    {
        if(!$request->ajax()) abort(500);
        $user = $userModel->where('otp_verification_token', '=', $code)
                        ->where('is_mobile_verified', '=', false)
                        ->first();
        if(empty($user->id) === true){
            return response()->json([
                'success' => false,
                'error' => __('message_account_creation_otp_failed')
            ]);
        }

        $country = $countryModel->find(config('settings.site_country'));
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|numeric|phone:'.$country->iso.',mobile'
        ]);
        if($validator->fails()){
            $errors = $validator->getMessageBag()->toArray();
            if(empty($errors['mobile_number'][0]) === false){
                return response()->json([
                    'success' => false,
                    'error' => $errors['mobile_number'][0]
                ]);
            }
        }

        $user->mobile = $request->get('mobile_number');
        if($user->save()){
            if($this->sendSMS(
                $user->mobile, 'otp-verification', [
                    '##OTP##' => $user->otp_code
                ]
            )){
                return response()->json([
                    'success' => true,
                    'error' => __('message_account_resend_otp_success')
                ]);
                
            }
            else{
                return response()->json([
                    'success' => false,
                    'error' => __('message_account_creation_otp_failed')
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'error' => __('message_account_creation_otp_failed')
        ]);
    }

    public function verifyOtp($code, Request $request, User $userModel)
    {
        $this->validate($request, [
            'otp' => 'required|numeric'
        ]);
        $user = $userModel->where('otp_verification_token', '=', $code)
                        ->where('is_mobile_verified', '=', false)
                        ->first();
        if(empty($user->id) === true){
            return redirect()->route('site.login')->with(
                'error', __('message_mobile_already_verified')
            );
        }

        if($user->otp_code != $request->get('otp')){
            return redirect()->back()->with(
                'error', __('message_invalid_otp')
            );
        }

        $emailVerificationRequired = empty(config('settings.email_verification')) === false && config('settings.email_verification') == 'Yes' ? true : false;
        $user->otp_verification_token = null;
        $user->otp_code = null;
        $user->is_mobile_verified = true;
        if($user->save()){
            if(empty($user->is_email_verified) === true){                
                if(!$emailVerificationRequired){
                    if(Auth::login($user, true)){
                        $login = $loginModel->create([
                            'user_id' => $user->id,
                            'user_agent' => $request->header('User-Agent'),
                            'ip_address' => $request->ip()
                        ]);
                        if(empty($login->id) === false){
                            return redirect()->intended('/');
                        }               
                    }
                }
                else{
                    $this->sendEmail($user->email, EmailTemplate::ACTIVATION, [
                        '##ACTIVATION_URL##' => route('site.email.activation', [
                            'code' => $user->email_verification_token
                        ]),
                        "##NAME##" => $user->getName()
                    ]);
                    return redirect()->route('site.login')->with(
                        'success', __('message_account_created_email_verify')
                    );
                }
            }
            else{
                return redirect()->route('site.login')->with(
                    'success', __('message_account_mobile_verified')
                );
            }
        }

        return redirect()->back()->with(
            'error', __('message_language_account_creation_failed')
        );
    }
}
