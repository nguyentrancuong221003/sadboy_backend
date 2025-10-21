<?php

namespace Modules\Client\Comment\src\Repositories;

use Modules\Client\Comment\src\Repositories\ClientCommentRepositoryInterface;
use App\Repositories\BaseRepository;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\isEmpty;
use Modules\Admin\Comment\src\Models\Comment;

class ClientCommentRepository extends BaseRepository implements ClientCommentRepositoryInterface {
    public function getModel()
    {
        return Comment::class;
    }

    public function getModelDetail(){
        return Comment::class;
    }

    public function addComment($data) {
        $user = auth()->guard('user')->user();
        $comment = $this->model->create([
            'code' => $data['code'],
            'content' => $data['content'],
            'imgs' => json_encode($data['imgs']) ?? NULL,
            'star' => $data['star'],
            'product_id' => $data['product_id'],
            'user_id' => $user->id
        ]);

        if (!$comment) {
            throw new \Exception("Thêm bình luận không thành công", 400);
        }
        $host = env('APP_URL');
        $data = [
            'id' => $comment->id,
            'code' => $comment->code,
            'product_id' => $comment->product_id,
            'name_user' => $comment->user->name,
            'email_user' => $comment->user->email,
            'img_user' => $comment->user->img,
            'content' => $comment->content,
            'star' => $comment->star,
            'imgs' => collect(json_decode($comment->imgs, true))->map(function($img) use($host) {
                return $host . $img;
            })
        ];
        return $data;
    }

}
