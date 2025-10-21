<?php

namespace Modules\Client\Cart\src\Repositories;
use App\Repositories\RepositoryInterface;

interface CartRepositoryInterface extends RepositoryInterface {

    public function getListCart($user_id, $page);

    public function deleteCart($id);

    public function addProductCart($data);

}
