<?php

namespace Modules\Admin\Provide\src\Repositories;
use App\Repositories\RepositoryInterface;

interface ProvideRepositoryInterface extends RepositoryInterface {
    public function getListProvide($start, $end);

    public function findProvide($page, $name, $count);

    public function deleteProvide($ids);

    public function createProvide($data);

    public function getDetailProvide($id, $page);

    public function loadAddOrderProvide($id, $page);

    public function EditProvide($id, $data);

    public function getListProvideDelete($start, $end);

    public function forceDelete($id);

    public function recoverProvideDelete($id);
}
