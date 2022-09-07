<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{ 
	public function list(Request $request)
	{
		$request->validate([
			'category_id' => 'nullable|exists:categories,id'
		]);
		$Product = Product::where('category_id', $request->category_id)->with('category')->paginate();
		$msg = "Products with categories fetched";
		
		return response(['success' => true, 'msg' => $msg, 'data' => $Product], 200);
	}
	
	public function save(ProductRequest $request)
	{
        if ($request->has('image'))
        {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.'. $extension;
            $file->move('uploads', $filename);  
        }

		$Product  = Product::create([
            'name' => $request->name,
			'sku' => str_replace(' ', '_', $request->sku),
			'category_id' => $request->category_id,
			'price' => $request->price,
			'discount' => $request->discount,
			'image' => $filename,
			'short_description' => $request->short_description,
			'long_description' => $request->long_description,
			'status' => $request->status
		]);
		
		if(!$Product){
			$msg = "Product dosen'/t save please try again";
			return response(['success' => false, 'msg' => $msg], 500);
		}
		
		$msg = "Product created successfully";
		return response(['success' => true, 'msg' => $msg, 'data' => $Product], 200);
	}
    
	public function show($id)
	{
		$Product = Product::where('id', $id)->with('category')->first();
		if(!$Product){
			$msg = "Product dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		
		$msg = "Product fetch successfuly";
		return response(['success' => true, 'msg' => $msg, 'data' => $Product], 200);
	}
	
	public function update(ProductRequest $request, $id)
	{
		$Product = Product::where('id', $id)->with('category')->first();
		if(!$Product){
			$msg = "Product dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}

		if ($request->has('image')){
			$image = 'uploads/'. $Product->image;
			
			if (File::exists($image)) {
				File::delete($image);
			}

			$file = $request->file('image');
			$extension = $file->getClientOriginalExtension();
			$filename = time(). '.'. $extension;
			$file->move('uploads', $filename);
		}

		$Product->update([
            'category_id' => $request->category_id,
			'name' => $request->name,
			'sku' => str_replace(' ', '_', $request->sku),
			'price' => $request->price,
			'discount' => $request->discount,
			'image' => $filename,
			'short_description' => $request->short_description,
			'long_description' => $request->long_description,
			'status' => $request->status
		]);
		
		$msg = "Product updated successfuly";
		return response(['success' => true, 'msg' => $msg, 'data' => $Product], 200);
	}
	
	public function delete($id)
	{
		$Product = Product::where('id', $id)->first();
		if(!$Product){
			$msg = "Product dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$Product->delete();
		$msg = "Product deleted successfully";
		
		return response(['success' => true, 'msg' => $msg], 200);
	}
}
