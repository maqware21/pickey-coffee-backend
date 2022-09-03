<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
	public function list()
	{
		$location = Location::with('user')->paginate(10);
		$msg = "Locations of login user";
		
		return response(['success' => true, 'msg' => $msg, 'data' => $location], 200);
	}
	
	public function save(LocationRequest $request)
	{
		$location  = Location::create([
			'user_id' => auth()->user()->id,
			'name' => $request->name,
			'address' => $request->address,
			'latitude' => $request->latitude,
			'longitude' => $request->longitude,
			'status' => $request->status
		]);
		
		if(!$location){
			$msg = "Location dosen'/t save please try again";
			return response(['success' => false, 'msg' => $msg], 500);
		}
		
		$msg = "Location created successfully";
		return response(['success' => true, 'msg' => $msg, 'data' => $location], 200);
	}
	
	public function update(LocationRequest $request, $id)
	{
		$location = Location::where('id', $id)->with('user')->first();
		if(!$location){
			$msg = "Location dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$location->update([
			'name' => $request->name,
			'address' => $request->address,
			'latitude' => $request->latitude,
			'longitude' => $request->longitude,
			'status' => $request->status
		]);
		
		$msg = "Location updated successfuly";
		return response(['success' => true, 'msg' => $msg, 'data' => $location], 200);
	}
	
	public function delete($id)
	{
		$location = Location::where('id', $id)->with('user')->first();
		if(!$location){
			$msg = "Location dosen'/t exists";
			return response(['success' => false, 'msg' => $msg], 403);
		}
		
		$location->delete();
		$msg = "Location deleted successfully";
		
		return response(['success' => true, 'msg' => $msg], 200);
	}
}
