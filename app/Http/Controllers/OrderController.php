<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
	public function list()
	{
		$order = Order::with('user', 'payment')->paginate(10);
		$msg = "Order with User fetched";
		
		return response(['success' => true, 'msg' => $msg, 'data' => $order], 200);
	}
	
	public function save(Request $request)
	{
		$request->validate([
			'user_id' => 'required|exists:users,id',
			'payment_id' => 'required|exists:payments,id',
			'total' => 'required'
		]);
		
		$payment = Payment::where('id', $request->payment_id)->with('user')->first();
		$order = Order::create([
			'user_id' => auth()->user()->id,
			'payment_id' => $payment->id,
			'total' => $request->total
		]);
		
		if(!$order){
			$msg = "Order dosen'/t save please try again";
			return response(['success' => false, 'msg' => $msg], 500);
		}
		
		$msg = "Order created successfully";
		return response(['success' => true, 'msg' => $msg, 'data' => $order], 200);
	}
	
	public function show(Order $order)
	{
		$orders = Order::where('id', $order)->with('user', 'payment')->first();
		if(!$orders){
			$msg = "Order dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$msg = "Order fetch successfuly";
		return response(['success' => true, 'msg' => $msg, 'data' => $orders], 200);
	}
	
	public function update(Request $request, Order $order)
	{
		$request->validate([
			'user_id' => 'required|exists:users,id',
			'payment_id' => 'required|exists:payments,id',
			'total' => 'required'
		]);
		
		$orders = Order::where('id', $order)->with('user', 'payment')->first();
		if(!$orders){
			$msg = "Order dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$payment = Payment::where('id', $request->payment_id)->with('user')->first();
		$order->update([
			'user_id' => auth()->user()->id,
			'payment_id' => $payment->id,
			'total' => $request->total
		]);
		
		$msg = "Order created successfully";
		return response(['success' => true, 'msg' => $msg, 'data' => $order], 200);
	}
	
	public function delete(Order $order)
	{
		$orders = Order::where('id', $order)->with('user', 'payment')->first();
		if(!$orders){
			$msg = "Order dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$orders->delete();
		$msg = "Order deleted successfuly";
		return response(['success' => true, 'msg' => $msg], 200);
	}
}
