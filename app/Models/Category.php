<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasFactory;

	protected $fillable = [
		'category_id',
		'name',
		'short_description',
		'long_description',
		'image'
	];

	public function categories()
	{
		return $this->belongsTo(Category::class);
	}
	
	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
