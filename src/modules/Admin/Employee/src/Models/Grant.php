<?php

namespace Modules\Admin\Employee\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    use HasFactory;

    protected $table = 'grants';

    public function employeeDetail()
    {
        return $this->hasMany(EmployeeDetails::class, 'grant_id', 'id');
    }
}
