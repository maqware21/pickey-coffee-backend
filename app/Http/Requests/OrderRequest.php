<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
	/**
	* Determine if the user is authorized to make this request.
	*
	* @return bool
	*/
	public function authorize()
	{
		return true;
	}
	
	/**
	* Get the validation rules that apply to the request.
	*
	* @return array
	*/
	public function rules()
	{
		return [
			'user_id' => 'nullable|exists:users,id',
			'payment_id' => 'nullable|exists:payments,id',
			'total_payment' => 'required',
			
			'product_id' => 'nullable|exists:products,id',
			'order_id' => 'nullable|exists:orders,id',
			// 'quantity' => 'required',
			'single_price' => 'nullable', 
			'total_price' => 'nullable'
		];
	}
}
