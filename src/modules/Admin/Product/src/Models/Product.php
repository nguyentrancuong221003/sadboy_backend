<?php

namespace Modules\Admin\Product\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Product\src\Models\ProductDetails;
use Modules\Admin\Product\src\Models\Category;
use Modules\Admin\Provide\src\Models\Provide;
use Modules\Admin\Comment\src\Models\Comment;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    protected $table = 'products';

    protected $casts = [
        'name' => 'string',
        'imgs' => 'array', // tự decode JSON string thành array
    ];

    protected $fillable = ['id', 'code', 'name', 'imgs', 'provide_id', 'category_id', 'place', 'slug', 'star', 'gift'];

    public function detail() {
        return $this->hasOne(
            ProductDetails::class,
            'product_id',
            'id'
        )->withTrashed();
    }

    public function category() {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'id'
        );
    }

    public function provide() {
        return $this->belongsTo(
            Provide::class,
            'provide_id',
            'id'
        );
    }

    public function comments(){
        return $this->hasMany(
            Comment::class,
            'product_id',
            'id'
        );
    }

}
