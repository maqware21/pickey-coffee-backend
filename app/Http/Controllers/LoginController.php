<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
	public function register(Request $request)
	{
		$request->validate([
			'fname' => 'required|max:30',
			'lname' => 'required|max:30',
			'phone_number' => 'required',
			'email' => 'required|email',
			'password' => 'required|string|min:6|confirmed'
		]);
		
		$auth_check = User::where('email', $request->email)->first();
		if($auth_check){
			$msg = "Email already exists"; 
			return response( ['success'=>false, 'msg'=>$msg],403 );
		}
		
		$user = User::create([
			'fname' => $request->fname,
			'lname' => $request->lname,
			'phone_number' => $request->phone_number,
			'email' => $request->email,
			'password' => Hash::make($request->password),
		]);
		
		$msg = "User register successfully";
		$data = ['success'=>true, 'msg' => $msg ,'User' => $user];
		return response ([$data], 200);
	}
	
	public function login(Request $request)
	{
		$request->validate([
			'username' => 'required',
			'password' => 'required'
		]);
		
		$auth_user = User::where('email', $request->username)->first();
		
		if (!$auth_user || !Hash::check($request->password, $auth_user->password)) {
			$msg = 'The Username and password you entered are not correct. Please double-check and try again.';
			return response(['success'=>false, 'msg'=>$msg], 404);
		}
		
		$msg = 'Login successfully.';
		
		$tokenResult = $auth_user->createToken($auth_user->email)->plainTextToken;
		$data = ['success' => true, 'msg' => $msg, 'token'=> $tokenResult , 'User' => $auth_user];
		return response([$data], 200);
	}
	
	public function logout(Request $request)
	{
		$request->user()->currentAccessToken()->delete();
		session()->flush();
		
		$msg = 'Logout successfully.';
		return response(['success'=> true, 'msg'=> $msg], 200);
	}
}