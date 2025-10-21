<?php

namespace Modules\Client\Order\src\Repositories;
use App\Repositories\RepositoryInterface;

interface ClientOrderRepositoryInterface extends RepositoryInterface {

    public function createOrder($data);

    public function getListOrder($user_id, $page, $count);

    public function getDetailOrder($user_id, $code);

    public function findOrder($user_id, $page, $code, $count);

    public function createOrderPending($data);

    public function payOrderPending($code, $money, $date);

    public function checkOrderPay($user_id, $code);
}
