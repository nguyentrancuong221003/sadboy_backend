<?php

namespace Modules\Admin\Employee\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    public function employeeDetail()
    {
        return $this->hasMany(EmployeeDetails::class, 'department_id', 'id');
    }
}
