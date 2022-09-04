<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    use HasFactory;


    protected $fillable = [
		'product_id',
		'order_id',
		'product_total'
	];

	public function products()
	{
		return $this->hasMany(Product::class, 'product_id');
	}
	
	public function order()
	{
		return $this->belongsTo(Order::class, 'order_id');
	}
	
}
