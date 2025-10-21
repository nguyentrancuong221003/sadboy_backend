<?php

namespace Modules\Admin\Voucher\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Voucher\factories\UserVoucherFactory;
class UserVoucher extends Model
{
    use HasFactory;

    protected $table = 'user_voucher';

    protected $fillable = [
        'user_id', 'voucher_id'
    ];

    protected static function newFactory()
    {
        return UserVoucherFactory::new();
    }
}
