<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
	public function create(CategoryRequest $request)
	{
		if ($request->has('image'))
		{
			$file = $request->file('image');
			$extension = $file->getClientOriginalExtension();
			$filename = time(). '.'. $extension;
			$file->move('uploads', $filename);  
		}

		$category = Category::create([
			'category_id' => @$request->category_id,
			'name' => $request->name,
			'short_description' => $request->short_description,
			'long_description' => $request->long_description,
			'image' => $filename
		]);
		
		if(!$category){
			$msg = "Category doesn'/t save please try again";
			return response(['success' => false, 'msg' => $msg], 500);
		}
		
		$msg = "Category saved";
		return response(['success' => true, 'msg' => $msg, 'data' => $category], 200);
	}
	
	public function list(Request $request)
	{
		$request->validate([
			'category_id' => 'nullable|exists:categories,id'
		]);
		
		$category = Category::where('category_id', $request->category_id)
		->with('categories')
		->paginate(10);

		return response(['success' => true, 'msg' => '', 'data' => $category], 200);
	}
	
	public function update(Request $request, $id)
	{
		$request->validate([
			'category_id' => 'nullable|exists:categories,id',
			'name' => 'required',
			'short_description' => 'required',
			'long_description' => 'required',
			'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
		]);

		$category = Category::where('category_id', $request->category_id)->with('categories')->first();
		if(!$category){
			$msg = "Category doesn'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		if ($request->has('image')){
			$image = 'uploads/'. $category->image;
			
			if (File::exists($image)) {
				File::delete($image);
			}

			$file = $request->file('image');
			$extension = $file->getClientOriginalExtension();
			$filename = time(). '.'. $extension;
			$file->move('uploads', $filename);
		}
		
		$category->categories()->update([
			'category_id' => @$request->category_id,
			'name' => $request->name,
			'short_description' => $request->short_description,
			'long_description' => $request->long_description,
			'image' => $filename
		]);

		if(!$category){
			$msg = "Category doesn'/t udpate please try again";
			return response(['success' => false, 'msg' => $msg], 500);
		}

		$msg = "Category updated";
		return response(['success' => true, 'msg' => $msg, 'data' => $category], 200);
	}

	public function delete($id)
	{
		$category = Category::where('id', $id)
		->with('categories')
		->first();

		if(!$category){
			$msg = "Category doesn'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}

		$category->delete();

		$msg = "Category deleted";
		return response(['success' => true, 'msg' => $msg], 200);
	}
}
