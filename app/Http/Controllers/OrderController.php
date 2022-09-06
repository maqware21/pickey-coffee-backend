<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Payment;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
	public function list()
	{
		$order = Order::with('user', 'payment')->paginate(10);
		$msg = "Order with User fetched";
		
		return response(['success' => true, 'msg' => $msg, 'data' => $order], 200);
	}
	
	public function save(OrderRequest $request)
	{	
		$payment = Payment::where('id', $request->payment_id)->with('user')->first();
		DB::beginTransaction();
		try{
			$order = Order::create([
				'user_id' => auth()->user()->id,
				'payment_id' => $payment->id,
				'location_id' => $request->location_id,
				'total_payment' => $request->total_payment,
				'delivery_date' => date('Y-m-d H:i:s', strtotime($request->delivery_date)),
			]);
			
			foreach ($request->products as $product) {
				$product = (object)$product;
				
				$product_id = Product::where('id', $product->product_id)->first();
				if(!$product_id) {
					throw new Exception("Invalid product.");
				}
			$order_detail = Order_detail::create([
				'product_id' => $product_id->id,
				'order_id' => $order->id, 
				'quantity' => $product->quantity,
				'single_price' => @$product_id->price,
				'total_price' => ($product->quantity * $product_id->price)
			]);
			// dd($order_detail);
		}
			DB::commit();
			
			$order_data = Order::whereId($order->id)->with('order_details')->first();
			$msg = "Order created successfully";
			return response(['success' => true, 'msg' => $msg, 'data' => $order_data], 200);
		} catch(Exception $e){
			DB::rollBack();
			// $msg = $e->getMessage();
			$msg = "Order dosen'/t save please try again";
			return response(['success' => false, 'msg' => $msg], 500);
		}
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
