<?php

namespace App\Models;

use App\Http\Traits\HasCompositePrimaryKeys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback_Order extends Model
{
    use HasFactory, HasCompositePrimaryKeys;

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = ['order_id', 'feedback_id'];

    protected $fillable = [
        'order_id',
        'feedback_id',
        'username',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->date = now();
        });
    }
}
