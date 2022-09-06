<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
	public function list()
	{
		$order_detail = Order_detail::with('order')->paginate(10);
		$msg = "Order_detail with order fetched";
		
		return response(['success' => true, 'msg' => $msg, 'data' => $order_detail], 200);
	}
	
	public function save(Request $request)
	{	
		$product = Product::where('id', $request->product_id)->first();
		$order = Order::where('id', $request->order_id)->first();
		
		$order_detail = Order_detail::create([
			'product_id' => $product->id,
			'order_id' => $order->id, 
			'product_total' => $request->product_total
		]);

		if(!$order_detail){
			$msg = "Order dosen'/t save please try again";
			return response(['success' => false, 'msg' => $msg], 500);
		}
		
		$msg = "Order_details created successfully";
		return response(['success' => true, 'msg' => $msg, 'data' => $order], 200);
	}
	
	public function show(Order_detail $order_detail)
	{
		$order = Order_detail::where('id', $order_detail)->with('order')->first();
		if(!$order){
			$msg = "Order_detail dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$msg = "Order_detail fetch successfuly";
		return response(['success' => true, 'msg' => $msg, 'data' => $order], 200);
	}
	
	public function update(Request $request, Order_detail $order_detail)
	{
		$request->validate([
			'product_id' => 'required|exists:products,id',
			'order_id' => 'required|exists:orders,id',
			'product_total' => 'required'
		]);
		
		$order_det = Order_detail::where('id', $order_detail)->with('order')->first();
		if(!$order_det){
			$msg = "Order_detail dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}

		$product = Product::where('id', $request->product_id)->first();
		$order = Order::where('id', $request->order_id)->first();
		
		$order_det->order->update([
			'product_id' => $product->id,
			'order_id' => $order->id, 
			'product_total' => $request->product_total
		]);
		
		$msg = "Order_details created successfully";
		return response(['success' => true, 'msg' => $msg, 'data' => $order_det], 200);
	}
}
