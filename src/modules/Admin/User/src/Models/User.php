<?php

namespace Modules\Admin\User\src\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\User\factories\UserFactory;
use Modules\Admin\User\src\Models\UserDetails;
use Modules\Admin\Voucher\src\Models\Voucher;
use Modules\Admin\Voucher\src\Models\UserVoucher;
use Modules\Admin\Order\src\Models\Order;
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code', 'name', 'email', 'img', 'phone', 'gender', 'password',
        'status', 'date_birth', 'date_create_account',
    ];

    protected $table = 'users';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    public function detail() {
        return $this->hasOne(
            UserDetails::class,
            'user_id',
            'id'
        )->withTrashed();
    }

    public function order() {
        return $this->hasMany(
            Order::class,
            'user_id',
            'id'
        );
    }
    public function vouchers() {
        return $this->belongsToMany(
            Voucher::class,
            UserVoucher::class,
            'user_id',
            'voucher_id'
        );
    }
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'pivot'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected static function newFactory()
    {
        return UserFactory::new();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
