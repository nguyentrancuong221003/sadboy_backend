<?php

namespace Modules\Admin\Stock\src\Repositories;
use App\Repositories\RepositoryInterface;

interface StockRepositoryInterface extends RepositoryInterface {
    public function getListStock($start, $end);
}
