<?php
namespace Modules\Admin\Order\src\Repositories;
use App\Repositories\RepositoryInterface;
interface OrderRepositoryInterface extends RepositoryInterface {
    public function getListOrder($start, $end);

    public function deleteOrder($ids);

    public function OrderConfirmAll();

    public function getDetailOrder($id);

    public function editOrder($id, $data);

    public function getListForceDelete($start, $end);

    public function forceDelete($id);

    public function recoverOrderDelete($id);

    public function findOrder($page, $find, $count);

    
}

