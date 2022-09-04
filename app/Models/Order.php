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
		'total'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
    
	public function payment()
	{
		return $this->belongsTo(User::class, 'payment_id');
	}

}
