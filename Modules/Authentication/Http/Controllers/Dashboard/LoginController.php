<?php

namespace Modules\Authentication\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Dashboard\LoginRequest;
use Modules\Authentication\Http\Requests\Dashboard\VerifyOTPRequest;
use PragmaRX\Google2FAQRCode\Google2FA;

class LoginController extends Controller
{
    use Authentication;

    /**
     * Display a listing of the resource.
     */
    public function showLogin()
    {
        return view('authentication::dashboard.auth.login');
    }

    /**
     * Login method
     */
    public function verify()
    {
        return view('authentication::dashboard.auth.verify');

    }

    public function postVerify(VerifyOTPRequest $request)
    {
        if(auth()->user()->google_2fa && auth()->user()->two_factor){

            $google2fa = new Google2FA();
            $verified = $google2fa->verifyKey(auth()->user()->google_2fa, $request->one_time_password);
            if(!$verified){
                auth()->logout();
                return redirect()->route('dashboard.login')->withErrors([
                    'one_time_password' => [
                        'Invalid OTP'
                    ]
                ]);
            }
            auth()->user()->update(['otp_verified'=>1]);
            return redirect()->route('dashboard.home');
        }
    }
    public function postLogin(LoginRequest $request)
    {
        $errors =  $this->login($request);

        if ($errors) {
            return redirect()->back()->withErrors($errors)->withInput($request->except('password'));
        }

        if(auth()->user()->two_factor && !auth()->user()->otp_verified){
            return redirect()->route('dashboard.auth.verify');
        }

        return redirect()->route('dashboard.home');
    }


    /**
     * Logout method
     */
    public function logout(Request $request)
    {
        auth()->user()->update(['otp_verified'=>0]);
        auth()->logout();
        return redirect()->route('dashboard.home');
    }
}
