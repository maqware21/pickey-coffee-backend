<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function SendEmailLink(Request $request)
	{
        $request->validate([
            'email' => 'required|email|exists:auth_users',
			'url' => 'required'
        ]);

		$token = Str::random(64);
		
		DB::table('password_resets')->insert([
			'email' => $request->email, 
			'token' => $token, 
			'created_at' => Carbon::now()
		]);
		
		$url = $request->url . '?email=' . $request->email . '&token=' . $token;
		
		// Mail::send('emails.forgetPassword', ['url' => $url], function($message) use($request){
		// 	$message->to($request->email);
		// 	$message->subject('Reset Password');
		// });
		
		$msg = 'Email has been successfully sent to you.';
		$data = [
			'email_token'	=> $token,
			'url'	=> $url
		];
		return response(['success' => true, 'msg'=> $msg, 'data' => $data]);
		// return response(200, $msg, $data);
	}
	
	public function submitResetPasswordForm(Request $request)
	{
        $request->validate([
            'email' => 'required|email|exists:auth_users',
			'token' => 'required',
			'password' => 'required|string|min:6|confirmed'
        ]);

		$updatePassword = DB::table('password_resets')->where([
			'email' => $request->email, 
			'token' => $request->token
			])->first();
			
			if (!$updatePassword) {
				$msg = 'Invalid token!';
				return response(['msg' => $msg], 403);
			}
			
			$user = User::where('email', $request->email)
			->update(['password' => Hash::make($request->password)]);
			
			DB::table('auth_users_password_resets')->where(['email'=> $request->email])->delete();
			
			$msg = 'Your password has been reset successfully.';
			
			return json_response(200, $msg);
		}	
}
