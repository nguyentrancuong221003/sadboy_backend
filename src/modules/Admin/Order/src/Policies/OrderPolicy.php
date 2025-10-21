<?php

namespace Modules\Admin\Order\src\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Admin\Employee\src\Models\Employee;
use Modules\Admin\Employee\src\Models\Module;
class OrderPolicy
{
    use HandlesAuthorization;

    protected function hasPermission(Employee $employee, string $action)
    {
        $employee = auth('employee')->user();
        $permissionRecord = Module::where('employee_id', $employee->id)->first();
        if (!$permissionRecord) {
            return false;
        }

        $permissions = json_decode($permissionRecord->permissions, true);

        if (!isset($permissions['order'])) {
            return false;
        }

        $orderPerms = $permissions['order'];
        if (in_array('all', $orderPerms)) {
            return true;
        }

        return in_array($action, $orderPerms);
    }
    public function __construct()
    {
        //
    }
    public function viewAny(Employee $employee)
    {
        return $this->hasPermission($employee, 'viewAny');
    }

    public function view(Employee $employee)
    {
        return $this->hasPermission($employee, 'view');
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


    public function viewDelete(Employee $employee) {
        return $this->hasPermission($employee, 'viewDelete');
    }
}
