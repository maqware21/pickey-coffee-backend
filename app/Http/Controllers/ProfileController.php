<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
	public function update(Request $request)
	{
		$request->validate([
			'fname' => 'required|max:30',
			'lname' => 'required|max:30',
			'phone_number' => 'required|numeric',
		]);
		
		User::where('id', auth()->user()->id)->update([
			'fname' => $request->fname,
			'lname' => $request->lname,
			'phone_number' => $request->phone_number,
		]);
		$user = User::where('id', auth()->user()->id)->first();

		$msg = "User profile updated successfully";
		return response(['success' => true, 'msg' => $msg, 'data' => $user], 200);
	}
	
	public function change_password(Request $request)
	{
		$request->validate([
			'password' => 'required|string|min:6|confirmed',
		]);

		$auth_user = auth()->user();
		$updated_pass = Hash::make($request->password);
		if (!Hash::check($request->current_password, $auth_user->password)) {
			$msg = 'Incorrect current password. Please double-check and try again.';
			
			return response(['success' => false, 'msg' => $msg], 400);
		}
		
		if ($request->current_password == $request->password) {
			$msg = 'New password can not be same as old password.';
			
			return response(['success' => false, 'msg' => $msg], 403);
		}

		$auth_user->password = $updated_pass;
		$auth_user->save();
		
		$user = User::find($auth_user->id);
		$user->password = $updated_pass;
		$user->save();
		
		$msg = 'Password updated successfully.';
		
		return response(['success' => true, 'msg' => $msg], 200);
	}
	
}
