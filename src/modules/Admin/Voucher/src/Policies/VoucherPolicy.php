<?php

namespace Modules\Admin\Voucher\src\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Admin\User\src\Models\User;
use Modules\Admin\Employee\src\Models\Employee;
use Modules\Admin\Employee\src\Models\Module;
class VoucherPolicy
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

        if (!isset($permissions['voucher'])) {
            return false;
        }

        $voucherPerms = $permissions['voucher'];
        if (in_array('all', $voucherPerms)) {
            return true;
        }

        return in_array($action, $voucherPerms);
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

    public function delete(Employee $employee)
    {
        return $this->hasPermission($employee, 'delete');
    }

    public function find(Employee $employee) {
        return $this->hasPermission($employee, 'find');
    }

    public function restore(Employee $employee)
    {
        return $this->hasPermission($employee, 'restore');
    }

    public function forceDelete(Employee $employee)
    {
        return $this->hasPermission($employee, 'forceDelete');
    }

    public function create(Employee $employee) {
        return $this->hasPermission($employee, 'add');
    }

    public function viewDelete(Employee $employee) {
        return $this->hasPermission($employee, 'viewDelete');
    }
}
