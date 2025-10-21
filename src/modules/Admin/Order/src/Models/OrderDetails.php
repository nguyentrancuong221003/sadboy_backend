<?php

namespace Modules\Admin\Order\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Order\factories\OrderDetailsFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderDetails extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens, Notifiable;

    protected $table = 'order_details';

    protected $fillable = [
        'address', 'pay', 'discount_code', 'unit_shipping', 'note', 'note_cancel', 'subtotal',
        'money_ship', 'money_discount','paid'
    ];

    protected static function newFactory()
    {
        return OrderDetailsFactory::new();
    }
}
