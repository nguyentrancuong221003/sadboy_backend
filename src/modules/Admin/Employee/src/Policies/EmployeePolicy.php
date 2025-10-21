<?php

namespace Modules\Admin\Employee\src\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Admin\Employee\src\Models\Employee;
use Modules\Admin\Employee\src\Models\Module;
class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    protected function hasPermission(Employee $employee, string $action)
    {
        $employee = auth('employee')->user();
        $permissionRecord = Module::where('employee_id', $employee->id)->first();
        if (!$permissionRecord) {
            return false;
        }

        $permissions = json_decode($permissionRecord->permissions, true);

        if (!isset($permissions['employee'])) {
            return false;
        }

        $employeePerms = $permissions['employee'];
        if (in_array('all', $employeePerms)) {
            return true;
        }

        return in_array($action, $employeePerms);
    }

    public function viewAny(Employee $employee)
    {
        return $this->hasPermission($employee, 'viewAny');
    }

    public function view(Employee $employee)
    {
        return $this->hasPermission($employee, 'view');
    }

    public function create(Employee $employee)
    {
        return $this->hasPermission($employee, 'add');
    }

    public function update(Employee $employee)
    {
        return $this->hasPermission($employee, 'update');
    }

    public function delete(Employee $employee)
    {
        return $this->hasPermission($employee, 'delete');
    }

    public function restore(Employee $employee)
    {
        return $this->hasPermission($employee, 'restore');
    }

    public function forceDelete(Employee $employee)
    {
        return $this->hasPermission($employee, 'forceDelete');
    }

    public function find(Employee $employee) {
        return $this->hasPermission($employee, 'find');
    }

    // public function addGoodReceipt(Employee $employee) {
    //     return $this->hasPermission($employee, 'addReceipt');
    // }

    public function viewDelete(Employee $employee) {
        return $this->hasPermission($employee, 'viewDelete');
    }
}

//   'employee' => ['view', 'viewAny', 'add', 'delete', 'viewDelete', 'forceDelete'],
