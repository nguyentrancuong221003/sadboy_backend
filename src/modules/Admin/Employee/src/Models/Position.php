<?php

namespace Modules\Admin\Employee\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Employee\src\Models\EmployeeDetails;
class Position extends Model
{
    use HasFactory;
    protected $table = 'positions';

    public function employeeDetail()
    {
        return $this->hasMany(EmployeeDetails::class, 'position_id', 'id');
    }
}
