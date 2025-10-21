<?php

namespace Modules\Admin\Cash_book\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Cash_book\factories\ProvideOrderMonthFactory;
class ProvideOrderMonth extends Model
{
    use HasFactory;

    protected $table ='provide_order_month';

    protected $fillable = [
        'code', 'date', 'count', 'description'
    ];

    protected static function newFactory()
    {
        return ProvideOrderMonthFactory::new();
    }
}
