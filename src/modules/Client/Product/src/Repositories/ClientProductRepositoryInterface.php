<?php

namespace Modules\Client\Product\src\Repositories;
use App\Repositories\RepositoryInterface;

interface ClientProductRepositoryInterface extends RepositoryInterface {

    public function getListCategory();

    public function ListProductByType($category, $page, $per_page);

    public function GetProductPopular($row, $col);

    public function getDetailProduct($slug);

    public function addCommentProduct($slug, $page);

    public function getProductName($page, $search, $count);

    public function getListProduct($start, $end);
}
