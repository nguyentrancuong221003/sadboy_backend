<?php

namespace Modules\Admin\Employee\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShifts extends Model
{
    use HasFactory;

    protected $table = 'work_shifts';

    public function employeeDetail()
    {
        return $this->hasMany(EmployeeDetails::class, 'work_shift_id', 'id');
    }
}
