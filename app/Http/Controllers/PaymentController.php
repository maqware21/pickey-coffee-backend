<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	public function list()
	{
		$payment = Payment::with('user')->paginate(10);
		$msg = "Payment with categories fetched";
		
		return response(['success' => true, 'msg' => $msg, 'data' => $payment], 200);
	}
	
	public function save(Request $request)
	{
		$request->validate([
			'payment_type' => 'required',
			'provider' => 'required',
			'user_id' => 'required|exists:users,id',
			'account_no' => 'required',
			'expiry' => 'required',
			'cvc_no' => 'required'
		]);
		
		$payment = Payment::create([
			'payment_type' => $request->payment_type,
			'provider' => $request->provider,
			'user_id' => auth()->user()->id,
			'account_no' => $request->account_no,
			'expiry' => $request->expiry,
			'cvc_no' => $request->cvc_no
		]);
		
		if(!$payment){
			$msg = "Payment dosen'/t save please try again";
			return response(['success' => false, 'msg' => $msg], 500);
		}
		
		$msg = "Payment created successfully";
		return response(['success' => true, 'msg' => $msg, 'data' => $payment], 200);
	}
	
	public function show(Payment $payment)
	{
		$pay = Payment::where('id', $payment)->with('user')->first();
		if(!$pay){
			$msg = "Payment dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$msg = "Payment fetch successfuly";
		return response(['success' => true, 'msg' => $msg, 'data' => $payment], 200);
	}
	
	public function update(Request $request, Payment $payment)
	{
		$request->validate([
			'payment_type' => 'required',
			'provider' => 'required',
			'user_id' => 'required|exists:users,id',
			'account_no' => 'required',
			'expiry' => 'required',
			'cvc_no' => 'required'
		]);
		
		$pay = Payment::where('id', $payment)->with('user')->first();
		if(!$payment){
			$msg = "Payment dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$pay->update([
			'payment_type' => $request->payment_type,
			'provider' => $request->provider,
			'user_id' => auth()->user()->id,
			'account_no' => $request->account_no,
			'expiry' => $request->expiry,
			'cvc_no' => $request->cvc_no
		]);
		
		$msg = "Payment created successfully";
		return response(['success' => true, 'msg' => $msg, 'data' => $pay], 200);
	}
	
	public function delete(Payment $payment)
	{
		$pay = Payment::where('id', $payment)->with('user')->first();
		if(!$pay){
			$msg = "Payment dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$pay->delete();
		$msg = "Payment deleted successfuly";
		return response(['success' => true, 'msg' => $msg], 200);
	}
}
