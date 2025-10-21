<?php

namespace Modules\Client\Cart\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\User\factories\CartFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Admin\User\src\Models\User;
use Modules\Admin\Product\src\Models\Product;
class Cart extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'code', 'product_id', 'count', 'size', 'user_id'
    ];
    public function user(){
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function product() {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'id'
        );
    }
    protected static function newFactory()
    {
        return CartFactory::new();
    }
}
