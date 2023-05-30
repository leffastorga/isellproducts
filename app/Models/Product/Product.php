<?php

namespace App\Models\Product;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'description',
        'price',
        'created_by',
        'deactivated_at'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
