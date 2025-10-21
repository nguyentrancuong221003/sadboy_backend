<?php

namespace Modules\Admin\Product\src\Repositories;
use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface {
    public function getListProduct($start, $end);

    public function deleteProduct($ids);

    public function findProduct($page, $name, $count);

    public function getListCategory();

    public function createProduct($data);

    public function getDetailProduct($id, $page);

    public function editProduct($id, $data);

    public function getListProductSupply($provide_id, $start, $end);

    public function findProductSupply($provide_id, $find, $page);

    public function addGoodsReceipt($data);

    public function getListProductDelete($start, $end);

    public function forceDelete($id);

    public function recoverProductDelete($id);

}
