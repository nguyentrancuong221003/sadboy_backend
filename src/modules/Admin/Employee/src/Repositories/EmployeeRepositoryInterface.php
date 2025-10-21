<?php

namespace Modules\Admin\Employee\src\Repositories;
use App\Repositories\RepositoryInterface;

interface EmployeeRepositoryInterface extends RepositoryInterface {
    public function getListEmployee($start, $end);

    public function getDetailEmployee($id);

    public function deleteEmployee($id);

    public function forceDelete($id);

    public function getListForceDelete($start, $end);

    public function recoverEmployeeDelete($id);

    public function createEmployee($data);

    public function editEmployee($id, $data);

    public function findEmployee($page, $find, $count);

    public function getPosition();

    public function getGrants();

    public function getContrasts();

    public function getWorkShifts();

    public function getDepartments();
}
