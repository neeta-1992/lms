<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB,Str,Error,Mail,Hash,Carbon\Carbon;
use App\Models\{
    User,PasswordReset
};
use App\Rules\CustomePassword;
use App\Mail\ForgotPassword;
use App\Mail\PasswordChanged;
class ForgotPasswordController extends Controller
{
     /**
       * Write code on Method
       *
       * @return response()
       */
    public function showForgetPasswordForm()
    {
        return view('auth.forgot-password');
    }


     /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
            $request->validate([
                'username' => 'required',
            ]);

            /*  */
            $username = $request->post('username');


            $userData = User::getData()->whereEn('username',$username)->first();
            $email  = $userData?->email ?? '' ;
            if(empty($email)){
                return back()->with('error', 'Username not exists')->withInput($request->post());
            }

            PasswordReset::resetPassword([
                'username'  =>$username,
                'email'     =>$email,
                'name'      =>$userData?->name,
                'userType'  =>$userData?->user_type,
            ]);


            return back()->with('status', 'We have e-mailed your password reset link!');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) {
        $passwordResets = PasswordReset::getData(['token'=>$token])->first();
        if(empty($passwordResets)){
            abort(404,'Token Not exists');
        }

        $createdAt = $passwordResets?->created_at ?? null;
        $createdAt = !empty($createdAt) ? Carbon::parse($createdAt)->addHour(1) : null;
        // check if it does not expired: the time is one hour
        if ($passwordResets->created_at > now()) {
            $passwordResets->delete();
            abort(404,'Token Is Expire');
        }

       // $passwordResets = $data
         return view('auth.reset-password', ['token' => $token]);
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request){
        $token = $request->post('token');
        $passwordResets = PasswordReset::getData(['token'=>$token])->first();
        if(empty($passwordResets)){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $username = $passwordResets?->username ?? null;
        $userType = $passwordResets?->user_type ?? null;
        $createdAt = $passwordResets?->created_at ?? null;
        $createdAt = !empty($createdAt) ? Carbon::parse($createdAt)->addHour(1) : null;
        // check if it does not expired: the time is one hour
        if ($passwordResets->created_at > now()) {
             $passwordResets->delete();
             return back()->withInput()->with('error', 'Token Is Expire!');
        }

        $request->validate([
            'token'                => 'required',
            'password'              => ['required',new CustomePassword($userType)],
            'password_confirmation' => ['required','same:password'],
        ]);


        $password = $request->password;
        $userData = User::getData(['username'=> $username])->first();
        if(empty($userData)){
            return back()->withInput()->with('error', 'Invalid User Id!');
        }
        $oldPassword = !empty($userData->old_passwords) ? json_decode($userData->old_passwords,true) : '' ;
        if(!empty($oldPassword)){
            foreach ($oldPassword as $key => $value) {
                if(Hash::check($password, $value)){
                    return back()->withInput()->with('error', 'You cannot use from your old 3 password.');
                }
            }
        }
        $password = Hash::make($password);
		$email  = $userData?->email ?? '' ;
		if(!empty($email)){
			Mail::to($email)->send(new PasswordChanged(['name' => $userData?->name]));
		}
        User::oldPassword($userData,$password);
        $passwordResets->delete();
        return redirect()->route('login')->with('status', 'Your password has been changed!');
      }

}
