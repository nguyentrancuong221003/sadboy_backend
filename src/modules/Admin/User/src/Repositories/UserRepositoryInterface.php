<?php
namespace Modules\Admin\User\src\Repositories;
use App\Repositories\RepositoryInterface;
interface UserRepositoryInterface extends RepositoryInterface {
    public function getListUser($start, $end);

    public function deleteUser($ids);

    public function getDetailUser($id);

    public function editUser($id, $data);

    public function findUser($page, $name, $count);

    public function getListForceDelete($start, $end);

    public function forceDelete($id);
    
    public function recoverUserDelete($id);
}
