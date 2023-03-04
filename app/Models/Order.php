<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'id',
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
            $model->id = IdGenerator::generate(['table' => 'orders', 'length' => 8, 'prefix' => 'P']);
        });
    }
}
