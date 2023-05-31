<?php

namespace App\Models\Payment;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_method_id',
        'user_id',
        'data'
    ];

    protected $casts = [
        'data' => 'encrypted:array' //encrypted because contains sensitive data (ex: card no, data that must send to payment gateway, etc.)
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function method(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
