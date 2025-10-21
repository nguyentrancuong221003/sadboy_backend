<?php

namespace Modules\Admin\Employee\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrast extends Model
{
    use HasFactory;

    protected $table = 'contrasts';

    public function employeeDetail()
    {
        return $this->hasMany(EmployeeDetails::class, 'contrast_id', 'id');
    }
}
