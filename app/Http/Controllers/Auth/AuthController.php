<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use App\Rules\Captcha;
use Carbon\Carbon;

use App\User;

class AuthController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $data = $request->all();
        if(isset($data['email'])){
            $user = User::where('email', $data['email'])->first();
            if(is_null($user)){
                return redirect()->route('login')->withErrors(['User not found']);
            }            
        }

        if(isset($data['password'])){
            if (!Hash::check($data['password'], $user->password)) {
                return redirect()->route('login')->withErrors(['Password mismatch']);
            }           
        }

        if(!empty($data['g-recaptcha-response'])){
            $result = captcha_validation($data['g-recaptcha-response']);
            if(!$result->success){
                return redirect()->route('login')->withErrors(['Invalid captcha']);
            }
        }else{
            return redirect()->route('login')->withErrors(['Please select captcha']);
        }
        

        if (Auth::attempt(['email' => $request->email, 
                            'password' => $request->password, 
                            'is_active' => User::FLAG_YES])) {

            //Deleted user may have duplicate entry so take active email address
            $user = User::where('email', $request->email)->where('is_active','YES')->first();
            $user->successful_login_count = intval($user->successful_login_count) + 1;
            $user->last_login_at = Carbon::now()->toDateTimeString();
            $user->save();

            return redirect()->intended('home');
        }else{
            return redirect()->route('login')->withErrors(['Not an active user']);
        }
    }
}