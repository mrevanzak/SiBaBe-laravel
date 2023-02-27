<?php

namespace App\Models;

use App\Http\Traits\HasCompositePrimaryKeys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCart extends Model
{
    use HasFactory, HasCompositePrimaryKeys;

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = ['product_id', 'cart_id'];

    protected $attributes = [
        'quantity' => 1,
    ];

    protected $fillable = [
        'product_id',
        'cart_id',
        'quantity',
        'total_price',
    ];
}
