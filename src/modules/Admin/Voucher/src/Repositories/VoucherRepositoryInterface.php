<?php
namespace Modules\Admin\Voucher\src\Repositories;
use App\Repositories\RepositoryInterface;
interface VoucherRepositoryInterface extends RepositoryInterface {

    public function getListVoucher($start, $end);

    public function deleteVoucher($ids);

    public function createVoucher($data);

    public function findVoucher($page, $code, $count);

    public function getDetailVoucher($id);

    public function getListVoucherDelete($start, $end);

    public function forceDelete($id);

    public function recoverVoucherDelete($id);

    public function editVoucher($id, $data);
}
