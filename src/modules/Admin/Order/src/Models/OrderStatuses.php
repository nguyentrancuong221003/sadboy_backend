<?php

namespace Modules\Admin\Order\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Order\factories\OrderStatusesFactory;
class OrderStatuses extends Model
{
    use HasFactory;

    protected $table = 'order_statuses';

    protected $fillable = [
        'code', 'order_id', 'status', 'location', 'note'
    ];

    protected static function newFactory()
    {
        return OrderStatusesFactory::new();
    }
}
