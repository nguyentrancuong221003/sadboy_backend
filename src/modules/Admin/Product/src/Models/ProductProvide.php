<?php

namespace  Modules\Admin\Product\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Product\factories\ProductProvideFactory;
class ProductProvide extends Model
{
    use HasFactory;

    protected $table = 'product_provide';

    protected static function newFactory()
    {
        return ProductProvideFactory::new();
    }

}
