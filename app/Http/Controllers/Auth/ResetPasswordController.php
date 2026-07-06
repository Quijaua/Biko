<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/alunos';

    /**
     * Reset the given user's password and mark email as verified.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        // only mark email as verified if the reset request included a matching verification code
        try {
            $my_token = request()->query('token') ?? request('token');
        } catch (\Throwable $e) {
            $my_token = null;
        }

        if ($my_token && isset($user->email_verification_code) && $my_token === $user->email_verification_code) {
            if (method_exists($user, 'hasVerifiedEmail') && ! $user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }
            // clear verification code after successful verification
            $user->email_verification_code = null;
        }

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }
}
