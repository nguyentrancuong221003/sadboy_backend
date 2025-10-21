<?php

namespace Modules\Admin\Order\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Order\factories\OrderFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Order\src\Models\OrderDetails;
use Modules\Admin\User\src\Models\User;
use Modules\Admin\Order\src\Models\OrderStatuses;
class Order extends Model
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'code', 'name', 'date_delivery', 'products', 'status', 'count', 'total', 'user_id'
    ];

    public function detail() {
        return $this->hasOne(
            OrderDetails::class,
            'order_id',
            'id'
        )->withTrashed();
    }

    public function user() {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function statuses() {
        return $this->hasMany(
            OrderStatuses::class,
            'order_id',
            'id'
        );
    }
    protected static function newFactory()
    {
        return OrderFactory::new();
    }
}
