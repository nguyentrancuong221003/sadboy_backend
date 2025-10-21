<?php

namespace Modules\Client\Voucher\src\Repositories;
use App\Repositories\RepositoryInterface;

interface ClientVoucherRepositoryInterface extends RepositoryInterface {

    public function findVoucher($code);

}
