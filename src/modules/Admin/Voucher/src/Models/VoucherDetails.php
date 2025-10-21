<?php

namespace Modules\Admin\Voucher\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Voucher\factories\VoucherDetailFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'voucher_details';

    protected $fillable = [
        'voucher_id', 'total_user', 'count_use', 'per_use', 'order_price_smallest', 'user_apply',
        'category_id', 'date_effect', 'date_end', 'status'
    ];

    protected static function newFactory()
    {
        return VoucherDetailFactory::new();
    }
}
