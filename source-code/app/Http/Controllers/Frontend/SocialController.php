<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use Storage;
use Socialite;
use App\Models\User;
use App\Models\Country;
use App\Utils\UserTypes;
use App\Models\UserLogin;
use App\Models\Attachment;
use App\Traits\SMSService;
use App\Models\UserAccount;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialController extends Controller
{
    use SMSService;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function connect($type, Request $request)
    {  
        $this->setSocialConfig($type);
        return Socialite::driver($type)->redirect();
    }


    public function socialCallback(
        $type, Request $request, User $user, UserAccount $userAccount, UserLogin $userLogin, UserProfile $profileModel, Attachment $attachmentModel
    )
    {
        $this->setSocialConfig($type);
        $socialData = Socialite::driver(strtolower($type))->user();
        if(empty($socialData->email) === true){
            return redirect()->route('site.login')->with('error', __('message_social_authentication_failed'));
        }
        
        $userModel = $user->where('email', '=', trim($socialData->email))->first();
        $avatar = null;
        $profileData = [];
        if(empty($userModel->id) === true){
            $userData = [
                'email' => trim($socialData->email),
                'password' => bcrypt(uniqid()),
                'is_email_verified' => true,
                'first_name' => $socialData->name,
                'user_type_id' => UserTypes::USER,
                'otp_verification_token' => md5(uniqid(rand(), true)),
                'user_agent' => $request->header('User-Agent'),
                'ip' => $request->ip()
            ];
            $provider = null;
            $profileData['gender'] = $this->getGender($socialData->user);
            if(strtolower($type) === 'google'){
                if(empty($socialData->user['link']) === false){
                    $profileData['google_url'] = $socialData->user['link'];
                }
            }

            if(strtolower($type) === 'facebook'){
                if(empty($socialData->profileUrl) === false){
                    $profileData['facebook_url'] = $socialData->profileUrl;
                }
            }

            $userModel = $user->create($userData);
            if(empty($userModel->id) === false){
                $profileData['user_id'] = $userModel->id;
                $userProfile = $profileModel->create($profileData);

                $userAccountModel = $userAccount->create([
                    'user_id' => $userModel->id,
                    'provider' => strtolower($type),
                    'login' => empty($socialData->id) === false ? trim($socialData->id) : null,
                    'is_primary' => true
                ]);

                if(empty($socialData->avatar_original) === false){
                    $filename = uniqid().'.jpg';
                    $avatar = 'User/'.$userModel->id.'/'.$filename;
                    $download = $this->downloadProfilePicture($avatar, $socialData->avatar_original);
                    if(empty($download) === true){
                        $avatar = null;
                    }

                    if(empty($avatar) === false){
                        $attachment = $attachmentModel->create([
                            'filename' => $filename,
                            'path' => $avatar,
                            'type' => 'User',
                            'foreign_id' => $userModel->id
                        ]);
                    }
                }

                return redirect()->route('site.add.mobile.number', ['code' => $userModel->otp_verification_token])->with('success', __('message_account_created_add_mobile_number'));
            }
        }
        else{
            $account = $userModel->getAccountByName($type, $socialData->id);
            if($account->count() == 0){
                $userAccountModel = $userAccount->create([
                    'user_id' => $userModel->id,
                    'provider' => strtolower($type),
                    'login' => empty($socialData->id) === false ? trim($socialData->id) : null
                ]);
            }
        }

        if(empty($userModel->id) === true){
            return redirect()->route('site.login')->with('error', __('message_social_authentication_failed'));
        }

        if(empty($userModel->mobile) === true){
            return redirect()->route('site.add.mobile.number', ['code' => $userModel->otp_verification_token])->with('success', __('message_account_must_add_mobile_number'));
        }

        if(empty($userModel->is_mobile_verified) === true){
            return redirect()->route('site.otp.resend', ['code' => $userModel->otp_verification_token])->with('error', __('message_mobile_not_verified'));
        }   

        if(empty($userModel->is_blocked) === false){
            return redirect()->route('site.login')->with('error', __('message_account_blocked'));
        }

        Auth::guard()->login($userModel, true);

        $loginLog = $userLogin->create([
            'user_agent' => $request->header('User-Agent'),
            'ip_address' => $request->ip(),
            'user_id' => $userModel->id
        ]);

        return redirect()->intended('/');
    }

    private function getGender($data)
    {
        $gender = 'M';
        if(empty($data) === false){
            if(empty($data['gender']) === false && strtolower($data['gender']) === 'female'){
                $gender = 'F';
            }
        }

        return $gender;
    }

    private function downloadProfilePicture($destination, $avatarUrl)
    {
        try {
            $content = file_get_contents($avatarUrl);
            if(Storage::disk('uploads')->put($destination, $content, 'public')){
                return true;               
            }
        }
        catch (\Exception $e) {
            return false;
        }

        return false;
    }

    protected function setSocialConfig($type)
    {
        switch ($type) {
            case 'facebook':
                config([
                    'services.facebook.client_id' => config('settings.facebook_app_id'),
                    'services.facebook.client_secret' => config('settings.facebook_app_secret'),
                    'services.facebook.redirect' => route('site.social.callback', ['provider' => 'facebook']),
                ]);
                break;
            default:
                break;
        }

        return;
    }    

    protected function sanitizeName($fullname) {
        $fullname = filter_var($fullname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $fullname = trim(strtolower($fullname));
        $fullname = preg_replace('/\s+/', '', $fullname);
        $fullname = preg_replace('/[^A-Za-z0-9\-]/', '', $fullname);

        return $fullname;
    }

    public function addMobileNumberForm(
        $code, Request $request, User $userModel, Country $countryModel
    )
    {
        $user = $userModel->where('otp_verification_token', '=', $code)
                        ->where('is_mobile_verified', '=', false)
                        ->firstOrFail();

        $country = $countryModel->find(config('settings.site_country'));
        $countryCode = null;
        $countryExt = null;
        if(empty($country->iso) === false){
            $countryCode = $country->iso;
            $countryExt = $country->phone_prefix;
        }

        return view('frontend.auth.add_mobile_number', [
            'user' => $user,
            'countryCode' => $countryCode,
            'countryExt' => $countryExt
        ]);
    }

    public function updateMobileNumber(
        $code, Request $request, User $userModel, Country $countryModel
    ){
        $user = $userModel->where('otp_verification_token', '=', $code)
                        ->where('is_mobile_verified', '=', false)
                        ->firstOrFail();

        $country = $countryModel->find(config('settings.site_country'));
        $countryCode = null;
        $countryExt = null;
        if(empty($country->iso) === false){
            $countryCode = $country->iso;
            $countryExt = $country->phone_prefix;
        }

        $this->validate($request, [
            'mobile_number' => 'required|unique:users,mobile|phone:'.$country->iso.',mobile',
        ]);

        $otp = generateOtp();
        $user->otp_code = $otp;
        $user->mobile = $request->get('mobile_number');
        if($user->save()){
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

        return redirect()->route('site.login')->with('error', __('message_social_authentication_failed'));

    }
}
