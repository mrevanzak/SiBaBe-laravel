<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'customer_username',
        'total_price',
        'status',
        'address',
        'courier',
        'cart_id',
        'total_product',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->invoice = IdGenerator::generate(['table' => 'orders', 'field' => 'invoice', 'length' => 8, 'prefix' => 'P']);
        });
    }
}
