<?php

namespace Modules\Admin\Cash_book\src\Repositories;
use App\Repositories\RepositoryInterface;

interface CashBookRepositoryInterface extends RepositoryInterface {
    public function getListGoodsReceipt($start, $end);

    public function FindGoodsReceipt($page, $code, $count);

    public function getDetailGoodsReceipt($id);

    public function editGoodsReceipt($id, $data);

    public function getDebtProvide($data);

    public function getListIncomeSpend($date, $page);

    public function findBillCollectSpend($page, $date, $code, $count);

    public function getOrderSuccess($start, $end);

    public function createBill($data);
}
