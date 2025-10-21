<?php
namespace Modules\Admin\Cash_book\src\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Admin\Employee\src\Models\Employee;
use Modules\Admin\Employee\src\Models\Module;

class BillCollectSpendPolicy
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

        if (!isset($permissions['cash_book'])) {
            return false;
        }

        $nillsPerms = $permissions['cash_book'];
        if (in_array('all', $nillsPerms)) {
            return true;
        }

        return in_array($action, $nillsPerms);
    }
    public function __construct()
    {
        //
    }
    public function addBill(Employee $employee)
    {
        return $this->hasPermission($employee, 'addBill');
    }
    
}
