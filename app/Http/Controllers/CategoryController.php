<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

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
			'category_id' => $request->category_id,
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
		return response(['success' => true, 'msg' => $msg], 200);
	}
}
