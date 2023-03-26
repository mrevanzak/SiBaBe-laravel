<?php

namespace App\Models;

use App\Http\Traits\HasCompositePrimaryKeys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_Order extends Model
{
    use HasFactory, HasCompositePrimaryKeys;

    public $incrementing = false;

    protected $primaryKey = ['admin_username', 'order_id'];

    protected $fillable = [
        'admin_username',
        'order_id',
        'update_status_order_to',
        'validations',
    ];
}
