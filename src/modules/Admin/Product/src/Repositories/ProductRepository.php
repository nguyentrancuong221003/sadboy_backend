<?php

namespace Modules\Admin\Product\src\Repositories;

use Modules\Admin\Product\src\Repositories\ProductRepositoryInterface;
use App\Repositories\BaseRepository;
use Modules\Admin\Product\src\Models\Product;
use Modules\Admin\Product\src\Models\ProductDetails;
use Modules\Admin\Product\src\Models\Category;
use Modules\Admin\Provide\src\Models\ProductProvideSupply;
use Modules\Admin\Comment\src\Models\Comment;
use Modules\Admin\Product\src\Models\GoodsReceipt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Admin\Cash_book\src\Models\DebtProvides;
use Modules\Admin\Product\src\Jobs\HandleGoodsReceiptDebt;
class ProductRepository extends BaseRepository implements ProductRepositoryInterface {
    public function getModel() {
        return Product::class;
    }

    public function getModelDetail() {
        return ProductDetails::class;
    }

    public function getDetailBase($product, $employee) {
        $host = env('APP_URL');
        $path = str_replace('/storage/', '', $product->detail->long_description);
        $imgs = [];
        $imgsData = json_decode($product->imgs, true); // decode JSON thành mảng

        if (!empty($imgsData) && is_array($imgsData)) {
            foreach ($imgsData as $img) {
                $imgs[] = $host . $img;
            }
        }

        // kiểm tra file tồn tại trước khi get
        $content = '';
        if (Storage::disk('public')->exists($path)) {
            $content = Storage::disk('public')->get($path);
            $content = html_entity_decode(str_replace('http://localhost:8000', $host, $content));
        }
        $data = [
            'id' => $product->id,
            'code' => $product->code,
            'name' => $product?->name,
            'imgs' => $imgs ?? null,
            'provide' => [
                'id' => $product->provide?->id,
                'code' => $product->provide?->code,
                'name' => $product->provide?->name,

            ],
            'sort_description' => $product->detail->sort_description,
            'long_description' => html_entity_decode(str_replace('http://localhost:8000', $host, $content) ),
            'category' => $product->category->code,
            'import_price' => json_decode($product->detail->import_price, true),
            'created_at' => Carbon::parse($product->created_at)->format('Y-m-d H:i:s'),
            'gift' => $product->gift,
            'place' => $product->place,
            'star' => $product->star,
            'count_comment' => $product->detail->count_comment,
            'original_price' => json_decode($product->detail->original_price, true),
            'sale_price' => json_decode($product->detail->sale_price, true),
            'OR' => $product->detail->OR,
            'proportion_discount' => $product->detail->proportion_discount,
            'date_start_sale' => $product->detail->date_start_sale,
            'date_end_sale' => $product->detail->date_end_sale,
            'count_stock' => $product->detail->count_stock,
            'count_sale' => $product->detail->count_sale,
            'status' => $product->detail->status,
            'unit' => $product->detail->unit,
            'created_by' => $employee->name ?? $product->detail->created_by
        ];
        return $data;
    }

    public function getComments($product) {
        $host = env('APP_URL');
        $comments = $product->comments()
        ->whereNull('parent_id')
        ->whereHas('user', function ($q) {
            $q->whereNull('deleted_at');
        })
        ->with([
            'children.user' => function($q) {
                $q->whereNull('deleted_at');
            },
            'user' => function($q) {
                $q->whereNull('deleted_at');
            }
        ])
        ->paginate(1);
        $dataComment = $comments->getCollection()->map(function ($comment) use ($host) {
            return [
                'id'   => $comment->id,
                'code' => $comment->code,
                'name_user' => $comment->user->name ?? '',
                'img_user' => $host . $comment->user->img,
                'email_user' => $comment->user->email,
                'star' => $comment->star,
                'created_at' => Carbon::parse($comment->created_at)->format('Y-m-d H:i:s'),
                'content' => $comment->content,
                'imgs' => json_decode($comment->imgs),
                'likes' => $comment->likes,
                'dislikes' => $comment->dislikes,
                'feedbacks' => $comment->children->map(function ($child) use ($host) {
                    return [
                        'id'   => $child->id,
                        'code' => $child->code,
                        'name_user' => $child->user->name ?? '',
                        'img_user' => $host . $child->user->img,
                        'email_user' => $child->user->email,
                        'star' => $child->star,
                        'created_at' => Carbon::parse($child->created_at)->format('Y-m-d H:i:s'),
                        'content' => $child->content,
                        'imgs' => json_decode($child->imgs),
                        'likes' => $child->likes,
                        'dislikes' => $child->dislikes,
                    ];
                }),
            ];
        });
        return $dataComment;
    }
    public function getListProduct($start, $end) {

        $count = $end - $start;
        $products = $this->model::with([
            'detail' => function($query) {
                $query->select('product_id', 'import_price', 'original_price', 'sale_price', 'count_sale');
            },
            'category' => function($query) {
                $query ->select('id', 'code', 'name');
            }
        ])
        ->skip($start)->take($count)
        ->latest()
        ->select('id', 'code', 'name', 'imgs', 'category_id')
        ->get();

        if ($products->isEmpty()) {
            throw new \Exception("Không tìm thấy sản phẩm trong khoảng yêu cầu", 404);
        }

        $host = env('APP_URL');

        $products = $products->map(function($product) use($host){
            return [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'img' => $host . ((($imgs = json_decode($product->imgs, true)) && isset($imgs[0])) ? $imgs[0] : null),
                'import_price' => json_decode($product->detail->import_price, true),
                'original_price:' => json_decode($product->detail->original_price, true),
                'sale_price' => json_decode($product->detail->sale_price, true),
                'category' => $product->category->code,
                'count_sale' => $product->detail->count_sale
            ];
        });
        return $products;
    }

    public function deleteProduct($ids) {
        return DB::transaction(function () use ($ids) {
            if (is_array($ids)) {
                $products = $this->model::whereIn('id', $ids)->whereNull('deleted_at');
                if(!$products->exists()) {
                    throw new \Exception('Không tìm thấy sản phẩm hợp lệ để xoá.', 404);
                }
                Cache::tags(array_merge(array_map(fn($id) => "product_id_$id", $ids)))->flush();
                $products->delete();
                $this->modelDetail::whereIn('product_id', $ids)->delete();
            }
            else {
                $product = $this->model::with('detail')->find($ids);
                if(!$product) {
                    throw new \Exception('Không tìm thấy sản phẩm hợp lệ để xoá.', 404);
                }

                if ($product->detail) {
                    $product->detail()->delete();
                }
                $product->delete();
                Cache::tags(["product_id_$ids"])->flush();
            }

        });
    }

    public function findProduct($page, $name, $count) {
        $products = $this->model::with([
            'detail' => function($query) {
                $query->select('product_id', 'import_price', 'original_price', 'sale_price', 'count_sale');
            },
            'category' => function($query) {
                $query ->select('id', 'code', 'name');
            }
        ])
        ->where('name', 'like', '%' . $name . '%')
        ->paginate($count);
        if ($products->isEmpty()) {
            throw new \Exception("Không tìm thấy sản phẩm phù hợp", 404);
        }
        $host = env('APP_URL');
        $products = $products->getCollection()->map(function($product) use($host){
            return [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'img' => $host . ((($imgs = json_decode($product->imgs, true)) && isset($imgs[0])) ? $imgs[0] : null),
                'import_price' => json_decode($product->detail->import_price, true),
                'original_price:' => json_decode($product->detail->original_price, true),
                'sale_price' => json_decode($product->detail->sale_price, true),
                'category' => $product->category->code,
                'count_sale' => $product->detail->count_sale
            ];
        });
        return $products;
    }

    public function getListCategory() {
        $categories = Category::select('id', 'code', 'name')->get();
        return $categories;
    }

    public function createProduct($data) {
        return DB::transaction(function () use ($data) {
            $employee=auth()->guard('employee')->user();

            $created = $product = $this->model->create([
                'code'    => $data['code'],
                'name'    => $data['name'],
                'imgs' => json_encode($data['imgs'], true) ?? NULL,
                'provide_id' => $data['provide_id'],
                'category_id' => $data['category_id'],
                'slug' => Str::slug($data['name']).'-'.$data['code'],
                'place' => $data['place'],
                'gift' => $data['gift'],
            ]);

            $createdDetail = $product->detail()->create([
                'product_id'    => $product->id,
                'import_price' => $data['import_price'],
                'original_price' => $data['original_price'],
                'sort_description' => $data['sort_description'],
                'long_description' => $data['long_description'],
                'count_stock' => $data['count_stock']
            ]);

            if (!$created || !$createdDetail) {
                throw new \Exception("Thêm sản phẩm không thành công", 400);
            }

            $data = $this->getDetailBase($product, $employee);
            Cache::tags(['products', "product_id_{$product->id}"])
                ->put("product_{$product->id}", $data, 600);
            return $data;
        });
    }

    public function getDetailProduct($id, $page) {

        $product_key = "product_$id";
        // nếu có cache và đang ở trang 1 thì dùng cache luôn
        if ($page == 1) {
            $product = Cache::tags(['products', "product_id_$id"])->get($product_key);
            if ($product) {
                return $product;
            }
        }

        $employee = auth()->guard('employee')->user();
        $product  = $this->model::with(['detail'])->find($id);

        if (!$product) {
            throw new \Exception("Không tìm thấy sản phẩm phù hợp yêu cầu", 404);
        }
        $productData = $this->getDetailBase($product, $employee);

        if ($page == 1) {
            $productData['comments'] = $this->getComments($product);
            Cache::tags(['products', "product_id_$id"])->put($product_key, $productData, 600);

            return $productData;
        }
        // nếu trang > 1 thì chỉ trả về comment
        return $this->getComments($product);
    }

    public function editProduct($id, $data) {
        return DB::transaction(function () use ($id, $data) {
            $employee=auth()->guard('employee')->user();
            $product = $this->model::with('detail')->find($id);
            $fieldProduct = ['code', 'name', 'imgs', 'provide_id', 'category_id', 'place', 'star', 'gift'];
            $pro = [];
            foreach ($fieldProduct as $field) {
                if (!empty($data[$field])) {
                    $pro[$field] = $data[$field];
                }
            }

            $fieldProductDetail = ['product_id', 'import_price', 'original_price', 'sale_price', 'sort_description', 'long_description',
                'count_comment', 'QR', 'proportion_discount', 'date_start_sale', 'date_end_sale', 'count_stock', 'count_sale', 'status', 'unit'
            ];

            $proDetail = [];
            foreach ($fieldProductDetail as $field) {
                if (!empty($data[$field])) {
                    $proDetail[$field] = $data[$field];
                }
            }


            $updated = $product->update($pro);
            $updatedDetail = $product->detail()->update($proDetail);


            if (!$updated || !$updatedDetail) {
                throw new \Exception("Cập nhập thông tin thất bại", 400);
            }

            $product->load([
                'detail'
            ]);
            $productData = $this->getDetailBase($product, $employee);
            $productData['comments'] = $this->getComments($product);
            // Xoá cache cũ
            Cache::tags(["product_id_$id"])->flush();

            //Lưu cache mới
            Cache::tags(['products', "product_id_$id"])->put("product_$id", $productData, 600);
            return $productData;

        });
    }

    public function getListProductSupply($provide_id, $start, $end) {
        $count = $end - $start;
        $products = ProductProvideSupply::skip($start)->take($count)
        ->select('id', 'code', 'name', 'img', 'price')
        ->latest()
        ->where('provide_id', $provide_id)
        ->get();

        if ($products->isEmpty()) {
            throw new \Exception("Không tìm thấy sản phẩm trong khoảng yêu cầu", 404);
        }
        $host = env('APP_URL');
        $products = $products->map(function($product) use($host){
            return [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'img' => $host.$product->img,
                'price' => json_decode($product->price, true)

            ];
        });
        return $products;
    }

    public function findProductSupply($provide_id, $find, $page) {
        $products = ProductProvideSupply::where('name', 'like', '%' . $find . '%')
        ->where('provide_id', $provide_id)
        ->paginate(3);
        if ($products->isEmpty()) {
            throw new \Exception("Không tìm thấy sản phẩm phù hợp", 404);
        }
        $host = env('APP_URL');
        $products = $products->map(function($product) use($host){
            return [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'img' => $host.$product?->img,
                'price' => json_decode($product->price, true)

            ];
        });
        return $products;
    }

    public function addGoodsReceipt($data) {
        return DB::transaction(function () use ($data) {

            $host = env('APP_URL');
            $products = collect($data['products'])->map(function($product) use($host){
                return [
                    'code' => $product['code'],
                    'img' => str_replace($host,'',$product['img']),
                    'name' => $product['name'],
                    'size' => $product['size'],
                    'subtotal' => $product['subtotal'],
                    'totalCount' => $product['totalCount']
                ];
            });

            $date = Carbon::now()->format('Y-m-d');
            $employee =auth()->guard('employee')->user();
            $data  = GoodsReceipt::create([
                'code' => $data['code'],
                'count' => $data['count'],
                'date_receive' => $data['date_receive'],
                'discount' => $data['discount'],
                'other_cost' => $data['other_cost'],
                'products' => json_encode($products),
                'stock_id' => $data['stock_id'],
                'subtotal' => $data['subtotal'],
                'status' => 'PENDING',
                'total' => $data['total'],
                'provide_id' => $data['provide_id'],
                'employee_id' => $employee->id
            ]);
            $data['products'] = json_decode($data['products'], true);

            $goodsData = [
                'id' => $data->id,
                'code' => $data->code,
                'created_at' => Carbon::parse($data->created_at)->format('Y-m-d h:m:s'),
                'provide_name' => $data->provide?->name,
                'stock_name' => $data->stock?->name,
                'status' => $data->status,
                'total' => number_format($data->total, 0, '.', ''),
            ];

            $debt = DebtProvides::whereDate('date', $date)->first();
            if($debt) {
                $debt->debt_arises= $data->total + $debt->debt_arises;
                $debt->debt_final =$debt->initial_debt	- $debt->debt_arises;
                $debt->save();
            }


            return $goodsData;
        });

    }

    public function getListProductDelete($start, $end) {
        $count = $end - $start;
        $products = $this->model::with([
            'detail' => function($query) {
                $query->select('product_id', 'import_price', 'original_price', 'sale_price', 'count_sale');
            },
            'category' => function($query) {
                $query ->select('id', 'code', 'name');
            }
        ])
        ->skip($start)->take($count)
        ->select('id', 'code', 'name', 'imgs', 'category_id')
        ->latest()
        ->onlyTrashed()
        ->get();

        if ($products->isEmpty()) {
            throw new \Exception("Không tìm thấy sản phẩm trong khoảng yêu cầu", 404);
        }
        $host = env('APP_URL');
        $products = $products->map(function($product) use($host){
            return [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'img' => $host . ((($imgs = json_decode($product->imgs, true)) && isset($imgs[0])) ? $imgs[0] : null),
                'import_price' => json_decode($product->detail->import_price, true),
                'category' => $product->category->code,
                'deleted_at' => Carbon::parse($product->deleted_at)->format('Y-m-d H:m:s')
            ];
        });
        return $products;
    }

    public function forceDelete($id) {
        $product = $this->model::with('detail')->onlyTrashed()->find($id);
        if(!$product) {
            throw new \Exception('Không tìm thấy sản phẩm', 404);
        }
        if ($product->detail) {
            $product->detail()->forceDelete();
            $product->forceDelete();
        }
    }

    public function recoverProductDelete($id) {

        $product = $this->model::with([
            'detail' => function($query) {
                $query->select('product_id', 'import_price');
            },
            'category' => function($query) {
                $query ->select('id', 'code', 'name');
            }
        ])
        ->select('id', 'code', 'name', 'imgs', 'category_id')
        ->onlyTrashed()
        ->find($id);

        if (!$product) {
            throw new \Exception("Không tìm thấy sản phẩm phù hợp yêu cầu", 404);
        }

        if($product->detail) {
            $product->detail()->restore();
            $product->restore();
        }
        else {
            throw new \Exception("Phục hồi sản phẩm không thành công", 400);
        }
        $host = env('APP_URL');
        $response = [
            'id' => $product->id,
            'code' => $product->code,
            'name' => $product->name,
            'img' => $host . ((($imgs = json_decode($product->imgs, true)) && isset($imgs[0])) ? $imgs[0] : null),
            'import_price' => json_decode($product->detail->import_price, true),
            'category' => $product->category->code,

        ];
        return $response;
    }


}
