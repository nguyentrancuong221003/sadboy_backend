<?php

namespace Modules\Admin\Product\src\Policies;

use Modules\Admin\Product\src\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Admin\Employee\src\Models\Employee;
use Modules\Admin\Employee\src\Models\Module;
class ProductPolicy
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

        // Nếu chưa có key 'product' trong JSON → không có quyền gì
        if (!isset($permissions['product'])) {
            return false;
        }

        $productPerms = $permissions['product'];
        // Có quyền 'all' → full quyền
        if (in_array('all', $productPerms)) {
            return true;
        }

        // Có quyền cụ thể (view, viewAny, update, delete...)
        return in_array($action, $productPerms);
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

    public function GoodsReceipt(Employee $employee) {
        return $this->hasPermission($employee, 'GoodsReceipt');
    }

    public function viewDelete(Employee $employee) {
        return $this->hasPermission($employee, 'viewDelete');
    }
}
