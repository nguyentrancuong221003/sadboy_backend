<?php

namespace Modules\Client\Comment\src\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Client\Comment\src\Repositories\ClientCommentRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Modules\Client\Comment\src\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Storage;
class CommentController extends Controller
{
    protected $commentRepo;

    public function __construct(ClientCommentRepositoryInterface $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }

    public function create(CommentRequest $request) {
        try {
            $data = $request->only([
                'code', 'content', 'imgs', 'star', 'product_id'
            ]);

            if ($request->hasFile('imgs')) {
                $paths = [];
                foreach ($request->file('imgs') as $img) {
                    $filename = $request->code . '_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $path = $img->storeAs(
                        'images/img_comment',
                        $filename,
                        'public'
                    );
                    $paths[] = '/storage/' . $path;
                }
                $data['imgs'] = $paths;
            }
            else {
                $data['imgs'] = NULL;
            }
            $comment = $this->commentRepo->addComment($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Đã thêm bình luận mới thành công',
                'data' => $comment
            ], 201, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Thên bình luận mới thất bại productController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $statusCode);
        }
    }
}
