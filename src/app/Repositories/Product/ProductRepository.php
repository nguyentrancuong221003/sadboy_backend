<?php
namespace App\Repositories\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Models\User;
class ProductRepository extends BaseRepository implements ProductRepositoryInterface {
    public function getModel()
    {
        return User::class; // quan trọng: phải trả về Model tương ứng
    }

    public function getProducts()
    {
        return $this->getAll(); // ví dụ: trả về tất cả sản phẩm hoặc
        // $this->model->all()
    }
}
