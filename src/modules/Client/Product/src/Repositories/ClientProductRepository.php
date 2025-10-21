<?php

namespace Modules\Client\Product\src\Repositories;

use Modules\Client\Product\src\Repositories\ClientProductRepositoryInterface;
use App\Repositories\BaseRepository;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\isEmpty;
use Modules\Admin\Product\src\Models\Product;
use Modules\Admin\Product\src\Models\Category;
use Illuminate\Support\Facades\Storage;
class ClientProductRepository extends BaseRepository implements ClientProductRepositoryInterface {
    public function getModel()
    {
        return Product::class;
    }

    public function getModelDetail(){
        return Product::class;
    }

    public function getListCategory() {
        $categories = Category::select('id', 'code', 'name')->get();
        return $categories;
    }

    public function ListProductByType($category, $page, $per_page) {

        $query = $this->model::with([
            'detail' => function($query) {
                $query->select('product_id','original_price', 'sale_price', 'count_sale');
            },
            'category' => function($query) {
                $query->select('id', 'code', 'name');
            }
        ])
        ->select('id', 'code', 'name', 'slug', 'imgs', 'category_id', 'gift', 'star', 'place');
        if ($category != 1) {
            $query->where('category_id', $category);
        }

        $products = $query->paginate($per_page);

        if ($products->isEmpty()) {
            throw new \Exception("Không tìm thấy sản phẩm phù hợp", 404);
        }
        $host = env('APP_URL');
        $pagination = [
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'per_page' => $products->perPage(),
            'total' => $products->total(),
        ];
        $products = $products->getCollection()->map(function($product) use($host){
            return [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'slug' => $product->slug,
                'img' => $host . ((($imgs = json_decode($product->imgs, true)) && isset($imgs[1])) ? $imgs[1] : null),
                'original_price' => json_decode($product->detail->original_price, true),
                'sale_price' => json_decode($product->detail->sale_price, true),
                'category' => $product->category->code,
                'count_sale' => $product->detail->count_sale,
                'gift' =>  $product->gift,
                'star' =>  $product->star,
                'place' => $product->place,
            ];
        });
        $data = [
            ...$pagination,
            'products' => $products
        ];


        return $data;
    }

    public function GetProductPopular($row, $col) {
        $count = $row*$col;
        $host = env('APP_URL');
        $productLatest = $this->model::with([
            'detail' => function($query) {
                $query->select('product_id','original_price', 'sale_price', 'count_sale');
            },
            'category' => function($query) {
                $query->select('id', 'code', 'name');
            }
        ])
        ->select('id', 'code', 'name', 'slug', 'imgs', 'category_id', 'gift', 'star', 'place')
        ->latest()
        ->take($count)
        ->get();

        $productLatest = $productLatest->map(function($product) use($host){
            return [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'slug' => $product->slug,
                'img' => $host . ((($imgs = json_decode($product->imgs, true)) && isset($imgs[1])) ? $imgs[1] : null),
                'original_price' => json_decode($product->detail->original_price, true),
                'sale_price' => json_decode($product->detail->sale_price, true),
                'category' => $product->category->code,
                'count_sale' => $product->detail->count_sale,
                'gift' =>  $product->gift,
                'star' =>  $product->star,
                'place' => $product->place,
            ];
        })->chunk($row)
        ->map(function ($chunk) {
            return $chunk->values();
        })->values()->toArray();

        $productSale = $this->model::join('product_details', 'products.id', '=', 'product_details.product_id')
        ->with([
            'detail:product_id,original_price,sale_price,count_sale',
            'category:id,code,name'
        ])
        ->select(
            'products.id',
            'products.code',
            'products.name',
            'products.slug',
            'products.imgs',
            'products.category_id',
            'products.gift',
            'products.star',
            'products.place',
            'product_details.count_sale'
        )
        ->orderBy('product_details.count_sale', 'desc')
        ->take($count)
        ->get();


        $productSale = $productSale->map(function($product) use($host){
            return [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'slug' => $product->slug,
                'img' => $host . ((($imgs = json_decode($product->imgs, true)) && isset($imgs[1])) ? $imgs[1] : null),
                'original_price' => json_decode($product->detail->original_price, true),
                'sale_price' => json_decode($product->detail->sale_price, true),
                'category' => $product->category->code,
                'count_sale' => $product->detail->count_sale,
                'gift' =>  $product->gift,
                'star' =>  $product->star,
                'place' => $product->place,
            ];
        })->chunk($row)
        ->map(function ($chunk) {
            return $chunk->values();
        })->values()->toArray();

        $productInterest = $this->model::with([
            'detail' => function($query) {
                $query->select('product_id','original_price', 'sale_price', 'count_sale');
            },
            'category' => function($query) {
                $query->select('id', 'code', 'name');
            }
        ])
        ->select('id', 'code', 'name', 'slug', 'imgs', 'category_id', 'gift', 'star', 'place')
        ->orderBy('interest', 'desc')
        ->take($count)
        ->get();

        $productInterest = $productInterest->map(function($product) use($host){
            return [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'slug' => $product->slug,
                'img' => $host . ((($imgs = json_decode($product->imgs, true)) && isset($imgs[1])) ? $imgs[1] : null),
                'original_price' => json_decode($product->detail->original_price, true),
                'sale_price' => json_decode($product->detail->sale_price, true),
                'category' => $product->category->code,
                'count_sale' => $product->detail->count_sale,
                'gift' =>  $product->gift,
                'star' =>  $product->star,
                'place' => $product->place,
            ];
        })->chunk($row)
        ->map(function ($chunk) {
            return $chunk->values();
        })->values()->toArray();

        $data = [
            [
                'title' => 'Sản phẩm mới nhất',
                'products' => $productLatest
            ],
            [
                'title' => 'Sản phẩm bán chạy nhất',
                'products' => $productSale
            ],
            [
                'title' => 'Sản phẩm được quan tâm nhất',
                'products' => $productInterest
            ]
        ];

        return  $data;
    }

    public function getDetailProduct($slug) {
        $product_key = "client_product_$slug";
        $product = Cache::tags(['client_products', "client_product_id_$slug"])->get($product_key);
        if ($product) {
            return $product;
        }
        $host = env('APP_URL');
        $product  = $this->model::with([
            'detail' => function($query) {
                $query->select('product_id', 'original_price', 'sale_price', 'sort_description', 'long_description');
            }
        ])
        ->where('slug', $slug)
        ->select('id', 'code', 'name', 'slug', 'imgs', 'gift', 'place', 'star', 'category_id')
        ->first();
        $content = '';
        $path = str_replace('/storage/', '', $product->detail->long_description);
        if (Storage::disk('public')->exists($path)) {
            $content = Storage::disk('public')->get($path);
            $content = html_entity_decode(str_replace('http://localhost:8000', $host, $content));
        }
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
        ->paginate(2);
        $data = [
            'id' => $product->id,
            'code' => $product->code,
            'name' => $product->name,
            'imgs' => collect(json_decode($product->imgs))->map(function($img) use($host) {
                return $host.$img;
            }),
            'sort_description' => $product?->detail?->sort_description,
            'long_description' => html_entity_decode(str_replace('http://localhost:8000', $host, $content) ),
            'category' => $product?->category?->code,
            'gift' => $product->gift,
            'place' => $product->place,
            'star' => $product->star,
            'original_price' => json_decode($product?->detail->original_price),
            'sale_price' => json_decode($product?->detail->sale_price),
            'comments' => $comments->getCollection()->map(function ($comment) use ($host) {
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
            })
        ];
        Cache::tags(['client_products', "client_product_id_$slug"])->put($product_key, $data, 600);
        return $data;
    }

    public function addCommentProduct($slug, $page) {

        $host = env('APP_URL');
        $product = $this->model::where('slug', $slug)
        ->first();

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
        ->paginate(2);

        $comments = $comments->getCollection()->map(function ($comment) use ($host) {
            return [
                'id'   => $comment->id,
                'code' => $comment->code,
                'name_user' => $comment->user->name ?? '',
                'img_user' => $host . $comment?->user?->img,
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
                        'img_user' => $host . $child?->user?->img,
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

        return $comments;
    }

    public function getProductName($page, $search, $count) {
        $products = $this->model::with([
            'detail' => function($query) {
                $query->select('product_id', 'import_price', 'original_price', 'sale_price', 'count_sale');
            },
            'category' => function($query) {
                $query ->select('id', 'code', 'name');
            }
        ])
        ->select('id', 'code', 'name', 'slug', 'imgs', 'gift', 'place', 'star', 'category_id')
        ->where('name', 'like', '%' . $search . '%')
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
                'slug' => $product->slug,
                'img' => $host . ((($imgs = json_decode($product->imgs, true)) && isset($imgs[1])) ? $imgs[1] : null),
                'original_price' => json_decode($product->detail->original_price, true),
                'sale_price' => json_decode($product->detail->sale_price, true),
                'category' => $product->category->code,
                'count_sale' => $product->detail->count_sale,
                'gift' =>  $product->gift,
                'star' =>  $product->star,
                'place' => $product->place,
            ];
        });
        return $products;
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
        ->select('id', 'code', 'name', 'slug', 'imgs', 'gift', 'place', 'star', 'category_id')
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
                'slug' => $product->slug,
                'img' => $host . ((($imgs = json_decode($product->imgs, true)) && isset($imgs[1])) ? $imgs[1] : null),
                'original_price' => json_decode($product->detail->original_price, true),
                'sale_price' => json_decode($product->detail->sale_price, true),
                'category' => $product->category->code,
                'count_sale' => $product->detail->count_sale,
                'gift' =>  $product->gift,
                'star' =>  $product->star,
                'place' => $product->place,
            ];
        });
        return $products;
    }
}
