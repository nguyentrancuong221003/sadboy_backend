<?php

namespace Modules\Admin\Employee\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Employee\factories\EmployeeDetailsFactory;
use Modules\Admin\Employee\src\Models\Position;
use Modules\Admin\Employee\src\Models\Department;
use Modules\Admin\Employee\src\Models\Grant;
use Modules\Admin\Employee\src\Models\Contrast;
use Modules\Admin\Employee\src\Models\WorkShifts;
use Illuminate\Database\Eloquent\SoftDeletes;
class EmployeeDetails extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'employee_details';

    protected $fillable = [
        'date_birth', 'date_start_work', 'salary', 'diploma', 'status', 'password',
        'date_sign_contrast', 'date_effect_contrast', 'date_end_contrast', 'work_shift_id', 'position_id',
        'department_id', 'grant_id', 'contrast_id'
    ];
    protected $primaryKey = 'employee_id';

    public $incrementing = false;

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function grant()
    {
        return $this->belongsTo(Grant::class, 'grant_id', 'id');
    }

    public function contrast()
    {
        return $this->belongsTo(Contrast::class, 'contrast_id', 'id');
    }

    public function workShifts()
    {
        return $this->belongsTo(WorkShifts::class, 'work_shift_id', 'id');
    }
    protected static function newFactory()
    {
        return EmployeeDetailsFactory::new();
    }
}
