<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CartRequest;
use Illuminate\Http\Request;
use App\Models\{Cart, Cart_detail, Product};

class CartController extends Controller
{
	public function list()
	{
		$cart = Cart::with('cart_details.products')->paginate(10); 
		return response(['success' => true, 'msg' => '', 'data' => $cart]);
	}
	
	public function save(CartRequest $request)
	{
		DB::beginTransaction();
		try {
			$cart = Cart::create([
				'user_id' => auth()->user()->id,
				'total' => $request->total,
				'status' => $request->status
			]);
			
			foreach ($request->products as $product) {
				$product = (object)$product;
				
				$product_id = Product::where('id', $product->product_id)->first();
				if(!$product_id) {
					throw new Exception("Invalid product.");
				}
				
				$cart_detail = Cart_detail::create([
					'product_id' => $product_id->id,
					'cart_id' => $cart->id,
					'quantity' => $product->quantity
				]);
			}
			DB::commit();
			
			$cart_data = Cart::whereId($cart->id)->with('cart_details')->first();
			$msg = "Cart created successfully";

			return response(['success' => true, 'msg' => $msg, 'data' => $cart_data], 200);
		} catch(Exception $e){
			DB::rollback();
			$msg = "Cart dosen'/t save please try again";
			return response(['success' => false, 'msg' => $msg], 500);
		}
	}
	
	public function show($id)
	{
		$cart = Cart::where('id', $id)->with('user', 'cart_details')->first();
		if(!$cart){
			$msg = "Cart dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$msg = "Cart fetch successfuly";
		return response(['success' => true, 'msg' => $msg, 'data' => $cart], 200);
	}
	
	public function update(Request $request, $id)
	{
		$cart = Cart::where('id', $id)->with('user')->first();
		if(!$cart){
			$msg = "Cart dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$product = Product::where('id', $request->product_id)->first();
		DB::beginTransaction();
		try {
			$cart->update([
				'user_id' => auth()->user()->id,
				'total' => $request->total,
				'status' => $request->status
			]);
			
			$cart_det = Cart_detail::where('cart_id', $cart->id)->delete();
			foreach ($request->products as $product) {
				$product = (object)$product;
				
				$product_id = Product::where('id', $product->product_id)->first();
				if(!$product_id) {
					throw new Exception("Invalid product.");
				}
				
				$cart_detail = Cart_detail::create([
					'product_id' => $product_id->id,
					'cart_id' => $cart->id,
					'quantity' => $product->quantity
				]);
			}			
			
			DB::commit();
			
			$msg = "Cart created successfully";
			return response(['success' => true, 'msg' => $msg, 'data' => $cart], 200);
			
		} catch(Exception $e){
			DB::rollback();
			$msg = "Cart dosen'/t save please try again";
			return response(['success' => false, 'msg' => $msg], 500);
		}
	}
	
	public function delete($id)
	{
		$cart = Cart::where('id', $id)->with('user', 'cart_details')->first();
		if(!$cart){
			$msg = "Cart dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$cart->cart_details()->delete();
		$cart->delete();
		
		$msg = "Cart deleted successfuly";
		return response(['success' => true, 'msg' => $msg], 200);
	}
}
