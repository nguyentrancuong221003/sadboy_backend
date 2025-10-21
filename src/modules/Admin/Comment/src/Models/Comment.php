<?php

namespace Modules\Admin\Comment\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Comment\factories\CommentFactory;
use Modules\Admin\User\src\Models\User;
use Modules\Admin\Product\src\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'code', 'content', 'imgs', 'likes', 'dislikes', 'star', 'parent_id', 'product_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    // Quan hệ cha
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Quan hệ con
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('children');
    }

    public function childRecursive()
    {
        return $this->children()->with('childRecursive');

    }
    protected static function newFactory()
    {
        return CommentFactory::new();
    }
}
