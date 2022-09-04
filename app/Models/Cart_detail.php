<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_detail extends Model
{
    use HasFactory;

    protected $fillable = [
		'product_id',
		'cart_id',
		'product_total'
	];

	public function products()
	{
		return $this->hasMany(Product::class, 'product_id');
	}
	
	public function cart()
	{
		return $this->belongsTo(Cart::class, 'cart_id');
	}
}
