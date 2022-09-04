<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
		'payment_type',
		'provider',
		'user_id',
		'account_no',
		'expiry',
		'cvc_no'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
    
}
