<?php

namespace Modules\Admin\Employee\src\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Modules\Admin\Employee\factories\EmployeeFactory;
use Modules\Admin\Employee\src\Models\EmployeeDetails;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject ;
class Employee extends Authenticatable implements JWTSubject
{
    use HasApiTokens, Notifiable, HasFactory, SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'code', 'name', 'email', 'phone', 'img',
        'address', 'gender', 'password'
    ];

    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    public function detail() {
        return $this->hasOne(EmployeeDetails::class, 'employee_id', 'id')->withTrashed();
    }

    public function position()
    {
        return $this->hasOneThrough(
            Position::class,          // Model cuối cùng (Position)
            EmployeeDetails::class,   // Model trung gian (EmployeeDetails)
            'employee_id',            // Khóa ngoại ở EmployeeDetails trỏ tới Employee
            'id',                     // Khóa chính ở Position (mặc định là id)
            'id',                     // Khóa chính ở Employee
            'position_id'             // Khóa ngoại ở EmployeeDetails trỏ tới Position
        )->withTrashed();
    }

    public function contrast()
    {
        return $this->hasOneThrough(
            Contrast::class,
            EmployeeDetails::class,
            'employee_id',
            'id',
            'id',
            'contrast_id'
        )->withTrashed();;
    }

    public function grant()
    {
        return $this->hasOneThrough(
            Grant::class,
            EmployeeDetails::class,
            'employee_id',
            'id',
            'id',
            'grant_id'
        )->withTrashed();;
    }

    public function department()
    {
        return $this->hasOneThrough(
            Department::class,
            EmployeeDetails::class,
            'employee_id',
            'id',
            'id',
            'department_id'
        )->withTrashed();;
    }

    public function workShift()
    {
        return $this->hasOneThrough(
            WorkShifts::class,
            EmployeeDetails::class,
            'employee_id',
            'id',
            'id',
            'word_shift_id'
        )->withTrashed();;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected static function newFactory()
    {
        return EmployeeFactory::new();
    }
}
