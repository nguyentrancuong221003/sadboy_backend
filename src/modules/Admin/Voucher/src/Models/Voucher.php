<?php

namespace Modules\Admin\Voucher\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Voucher\factories\VoucherFactory;
use Modules\Admin\Voucher\src\Models\VoucherDetails;
use Modules\Admin\Product\src\Models\Category;
use Modules\Admin\User\src\Models\User;
class Voucher extends Model
{
    use HasFactory, SoftDeletes, Notifiable, HasApiTokens;

    protected $table = 'vouchers';

    protected $fillable = [
        'code', 'name', 'img', 'type', 'percent', 'max_money', 'money_discount'
    ];

    public function detail(){
        return $this->hasOne(
            VoucherDetails::class,
            'voucher_id',
            'id'
        )->withTrashed();
    }

    public function category()
    {
        return $this->hasOneThrough(
            Category::class,
            VoucherDetails::class,
            'voucher_id',
            'id',
            'id',
            'category_id'
        );
    }

    public function monopoly() {
        return $this->belongsToMany(
            User::class,
            'user_voucher',
            'voucher_id',
            'user_id'
        )->withTimestamps();
    }
    protected $hidden = ['pivot'];

    protected static function newFactory()
    {
        return VoucherFactory::new();
    }
}
