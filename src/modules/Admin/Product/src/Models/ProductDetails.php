<?php

namespace Modules\Admin\Product\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Product\factories\ProductDetailsFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductDetails extends Model
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    protected $table = 'product_details';

    protected $casts = [
        'import_price'   => 'array',
        'original_price' => 'array',
        'sale_price'     => 'array',
    ];

    protected $fillable = ['product_id', 'import_price', 'original_price', 'sale_price', 'sort_description', 'long_description',
        'count_comment', 'QR', 'proportion_discount', 'date_start_sale', 'date_end_sale', 'count_stock', 'count_sale', 'status', 'unit', 'created_by', 'updated_by'
    ];
    protected static function newFactory()
    {
        return ProductDetailsFactory::new();
    }
}
