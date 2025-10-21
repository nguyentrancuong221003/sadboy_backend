<?php

namespace Modules\Admin\Order\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class OrderPending extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'orders_pending';

    protected $fillable = [
        'code', 'name', 'date_delivery', 'products', 'status', 'count', 'total', 'user_id', 'address', 'pay',
        'discount_code', 'unit_shipping', 'note', 'note_cancel', 'subtotal', 'money_discount', 'money_ship', 'paid'
    ];
}
