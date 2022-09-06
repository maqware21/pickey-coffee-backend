<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
		'user_id',
		'payment_id',
		'location_id',
		'total_payment',
		'delivery_date',
		'status'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
    
	public function order_details()
	{
		return $this->hasMany(Order_detail::class);
	}

	public function payment()
	{
		return $this->belongsTo(Payment::class, 'payment_id');
	}

	// public function location()
	// {
	// 	return $this->belongsTo(Location::class, 'location_id');
	// }
}
