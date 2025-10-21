<?php

namespace Modules\Client\Account\src\Repositories;
use App\Repositories\RepositoryInterface;

interface ClientUserRepositoryInterface extends RepositoryInterface {

    public function createUser($data);

    public function editUser($id, $data);

    public function voucherMonopoly($id, $page, $count);
}
