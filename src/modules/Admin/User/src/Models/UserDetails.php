<?php

namespace Modules\Admin\User\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\User\factories\UserDetailsFactory;
use Modules\Admin\User\src\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_details';

    protected $fillable = [
        'status', 'date_birth', 'date_create_account', 'money_spend', 'type', 'number_carts', 'total_order',
        'total_order_cancel', 'total_order_success', 'comment_count',
    ];

    public function user() {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        )->withTrashed();
    }

    protected static function newFactory()
    {
        return UserDetailsFactory::new();
    }
}
