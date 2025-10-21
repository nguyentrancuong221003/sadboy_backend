<?php

namespace Modules\Client\Product\src\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Client\Product\src\Repositories\ClientProductRepositoryInterface;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CheckStartEndRequest;
class ProductController extends Controller
{
    protected $productRepo;

    public function __construct(ClientProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getCategories(Request $request) {
        try {
            $categories = $this->productRepo->getListCategory();

            return response()->json([
                'status' => 'success',
                'message' => 'Lấy thông tin danh mục thành công',
                'data' => $categories
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        catch(\Exception $e) {
            Log::error('Lấy danh mục sản phẩm thất bại ở client trong productController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 404, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function ProductsType(Request $request) {
        try {
            $category = $request->input('category', 6);
            $page = $request->input('page', 1);
            $per_page = $request->input('per_page', 30);

            $product = $this->productRepo->ListProductByType($category, $page, $per_page);
            return response()->json([
                'status' => 'success',
                'message' => 'Lấy danh sách sản phẩm thành công',
                'data' => $product ?? []
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        catch(\Exception $e) {
            Log::error('Lấy danh mục sản phẩm thất bại ở client trong productController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 404, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function ProductsPopular(Request $request) {
        try {
            $row = $request->input('row', 3);
            $col = $request->input('col', 3);

            $product = $this->productRepo->GetProductPopular($row, $col);
            return response()->json([
                'status' => 'success',
                'message' => 'Lấy danh sách sản phẩm thành công',
                'data' => $product ?? []
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            Log::error('Lấy danh mục sản phẩm thất bại ở client trong productController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 404, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

    }

    public function show(Request $request) {
        try {
            $slug = $request->input('slug');
            $product = $this->productRepo->getDetailProduct($slug);
            return response()->json([
                'status' => 'success',
                'message' => 'Thông tin chi tiết của sản phẩm',
                'data' => $product,

            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin sản phẩm thất bại productController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function addComment(Request $request) {
        try {
            $slug = $request->input('slug');
            $page = $request->input('page');
            $comments = $this->productRepo->addCommentProduct($slug, $page);
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm bình luận thành công',
                'data' => $comments,

            ], 201, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin bình luận thất bại productController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function findName(Request $request) {
        try {
            $page = $request->input('page');
            $search = $request->input('search');
            $count = $request->input('count');
            $product = $this->productRepo->getProductName($page, $search, $count);
            return response()->json([
                'status' => 'success',
                'message' => 'Danh sách sản phẩm',
                'data' => $product,

            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin sản phẩm thất bại productController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function index(CheckStartEndRequest $request) {
        try {
            $start = $request->input('start', 0);      // bắt đầu từ bản ghi nào
            $end = $request->input('end', 20);
            $products = $this->productRepo->getListProduct($start, $end);

            return response()->json([
                'status' => 'success',
                'message' => 'Danh sách sản phẩm',
                'data' => $products
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy danh sách sản phẩm thất bại ở trong productController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }
}
