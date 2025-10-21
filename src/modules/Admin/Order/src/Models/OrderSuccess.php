<?php

namespace Modules\Admin\Order\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Order\factories\OrderSuccessFactory;
use Modules\Admin\Order\src\Models\Order;
class OrderSuccess extends Model
{
    use HasFactory;

    protected $table = "order_success";

    protected $fillable = [
        'order_id', 'total_import_price', 'discount_price', 'total_sale_price', 'total_profitable_price'
    ];

    public function order(){
        return $this->belongsTo(
            Order::class,
            'order_id',
            'id'
        );
    }
    protected static function newFactory()
    {
        return OrderSuccessFactory::new();
    }
}
