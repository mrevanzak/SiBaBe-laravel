<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'admin_username',
        'total_cost',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->admin_username = auth()->user()->username;
        });
    }
}
