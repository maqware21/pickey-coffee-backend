<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class VerifyEmailController extends Controller
{
	public function SendVerificationEmail(Request $request)
	{
		$request->validate([
			'url' => 'required'
		]);
		
		$token = Str::random(64);
		$user = Auth::user();
		
		$user->verification_token = $token;
		$user->save();
		
		$url = $request->url . '?email=' . $user->email . '&token=' . $token;
		
		// Mail::send('emails.emailVerification', ['url' => $url, 'verify_code'=> 0], function($message) use($user){
		// 	$message->to($user->email);
		// 	$message->subject('Verfiy Email');
		// });
		
		$data = array(['email_code'=> $token]);
		$msg = 'Verification email has been successfully sent to you.';
		return response(['success' => true, 'msg' => $msg, 'data' => $data], 200);
	}
	
	public function VerifyEmail(Request $request)
	{
		$request->validate([
			'email' => 'required|email|exists:users',
			'token' => 'required'
		]);
		
		$VerifyEmail = User::where([
			'email' => $request->email, 
			'verification_token' => $request->token
			])->first();
			
		if(!$VerifyEmail){
			$msg = 'Invalid token!';
			
			return response(['success' => false, 'msg' => $msg], 403);
		}
			
		$auth_user = User::where('email', $request->email)
		->update([
			'email_verified_at' => Carbon::now(),
			'verification_token' => ''
		]);
		
		$msg = 'Email verfied successfully.';
		
		return response(['success' => true , 'msg' => $msg], 200);
	}
}
	