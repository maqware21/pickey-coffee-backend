<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cart_detail;
use App\Models\Product;
use Illuminate\Http\Request;

class CartDetailController extends Controller
{
	// public function list()
	// {
	// 	$cart_detail = Cart_detail::with('cart', 'products')->paginate(10);
	// 	$msg = "Cart_detail with cart fetched";
		
	// 	return response(['success' => true, 'msg' => $msg, 'data' => $cart_detail], 200);
	// }
	
	// public function save(Request $request)
	// {
	// 	$request->validate([
	// 		'product_id' => 'required|exists:products, id',
	// 		'cart_id' => 'required|exists:carts, id',
	// 		'product_total' => 'required'
	// 	]);
		
	// 	$product = Product::where('id', $request->product_id)->first();
	// 	$cart = Cart::where('id', $request->cart_id)->first();
	// 	$cart_detail = Cart_detail::create([
	// 		'product_id' => $product->id,
	// 		'cart_id' => $cart->id,
	// 		'product_total' => $request->total
	// 	]);
		
	// 	if(!$cart_detail) {
	// 		$msg = "Cart details  dosen'/t save please try again";
	// 		return response(['success' => false, 'msg' => $msg], 500);
	// 	}

	// 	$msg = "Cart details created successfully";
	// 	return response(['success' => true, 'msg' => $msg, 'data' => $cart_detail], 200);
	// }
	
	// public function show(Cart_detail $cart_detail)
	// {
	// 	$cart_detail = Cart_detail::where('id', $cart_detail)->with('cart', 'products')->first();
	// 	if(!$cart_detail){
	// 		$msg = "Cart_detail dosen'/t exists";
	// 		return response(['success' => false, 'msg' => $msg], 403);
	// 	}
		
		
	// 	$msg = "Cart_detail fetch successfuly";
	// 	return response(['success' => true, 'msg' => $msg, 'data' => $cart_detail], 200);
	// }
	
	// public function update(Request $request, Cart_detail $cart_detail)
	// {
	// 	$request->validate([
	// 		'product_id' => 'required|exists:products, id',
	// 		'cart_id' => 'required|exists:carts, id',
	// 		'product_total' => 'required'
	// 	]);

	// 	$cart_detail = Cart_detail::where('id', $cart_detail)->with('cart', 'products')->first();
	// 	if(!$cart_detail){
	// 		$msg = "Cart_detail dosen'/t exists";
	// 		return response(['success' => false, 'msg' => $msg], 403);
	// 	}

	// 	$product = Product::where('id', $request->product_id)->first();
	// 	$cart = Cart::where('id', $request->cart_id)->first();

	// 	$cart_detail->update([
	// 		'product_id' => $product->id,
	// 		'cart_id' => $cart->id,
	// 		'product_total' => $request->total
	// 	]);

	// 	$msg = "Cart details updated successfully";
	// 	return response(['success' => true, 'msg' => $msg, 'data' => $cart_detail], 200);
	// }
	
	// public function delete(Cart_detail $cart_detail)
	// {
	// 	$cart_detail = Cart_detail::where('id', $cart_detail)->with('cart')->first();
	// 	if(!$cart_detail){
	// 		$msg = "Cart_detail dosen'/t exists";
	// 		return response(['success' => false, 'msg' => $msg], 403);
	// 	}
		
	// 	$cart_detail->delete();
	// 	$msg = "cart_detail deleted successfully";
		
	// 	return response(['success' => true, 'msg' => $msg], 200);
	// }
}
