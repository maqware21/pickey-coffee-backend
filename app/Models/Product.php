<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
	protected $fillable = [
		'name',
		'sku',
		'category_id',
		'price',
		'short_description',
		'long_description',
		'image',
		'discount',
		'status',
	];

	public function category()
	{
		return $this->belongsTo(Category::class,'category_id');
	}

}
