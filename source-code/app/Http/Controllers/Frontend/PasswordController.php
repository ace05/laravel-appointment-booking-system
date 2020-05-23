<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\EmailService;
use App\Utils\EmailTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    use ResetsPasswords, EmailService;

    public $redirectTo = '/';

   public function __construct()
   {
       $this->middleware('guest');
   }

    public function showLinkRequestForm()
    {
        return view('frontend.auth.email');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('frontend.auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function sendResetLinkEmail(Request $request, User $userModel)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users'
        ]);

        $user = $userModel->where('email', '=', $request->get('email'))
                        ->first();
        if(empty($user->id) === false){
            $passwordBroker = app(PasswordBroker::class);
            $token = $passwordBroker->createToken($user);
            $reset = \DB::table('password_resets')->insert([
                'email' => $user->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);

            if($reset){
                $this->sendEmail($user->email, EmailTemplate::RESET_PASSWORD, [
                    '##RESET_URL##' => route('password.reset', [
                        'token' => $token
                    ]),
                    "##NAME##" => $user->getName()
                ]);
                return redirect()->route('site.forgot.password')->with(
                    'success', __('message_password_reset_email_success')
                );
            }
        }

        return redirect()->route('site.forgot.password')->with('error', __('message_password_reset_email_failed'));
    }
}