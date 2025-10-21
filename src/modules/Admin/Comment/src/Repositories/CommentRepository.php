<?php

namespace Modules\Admin\Comment\src\Repositories;

use  Modules\Admin\Comment\src\Repositories\CommentRepositoryInterface;
use App\Repositories\BaseRepository;
use Modules\Admin\Comment\src\Models\Comment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
class CommentRepository extends BaseRepository implements CommentRepositoryInterface {
    public function getModel() {
        return Comment::class;
    }

    public function getModelDetail() {
        return Comment::class;
    }

    public function getListComment($start, $end) {
        $count = $end - $start;
        $comments = $this->model::skip($start)->take($count)
        ->select('id', 'code', 'created_at', 'likes', 'star', 'content')
        ->latest()
        ->get();

        if ($comments->isEmpty()) {
            throw new \Exception("Không tìm thấy bình luận trong khoảng yêu cầu", 404);
        }

        $comments = $comments->map(function($comment) {
            return [
                'id' => $comment->id,
                'code' => $comment->code,
                'created_at' => Carbon::parse($comment->created_at)->format('y-m:d h:m:s'),
                'like' => $comment->likes,
                'star' => $comment->star,
                'content' => $comment->content
            ];
        });
        return $comments;
    }

    public function findComment($page, $code, $count) {
        $comments = $this->model::where('code', 'like', '%' . $code . '%')
        ->select('id', 'code', 'created_at', 'likes', 'star', 'content')
        ->paginate($count);
        if ($comments->isEmpty()) {
            throw new \Exception("Không tìm thấy bình luận phù hợp", 404);
        }
        $comments = $comments->getCollection()->map(function($comment) {
            return [
                'id' => $comment->id,
                'code' => $comment->code,
                'created_at' => Carbon::parse($comment->created_at)->format('y-m:d h:m:s'),
                'like' => $comment->likes,
                'star' => $comment->star,
                'content' => $comment->content
            ];
        });
        return $comments;
    }

    public function deleteComment($ids) {

        return DB::transaction(function () use ($ids) {
            if (is_array($ids)) {
                $comments = $this->model::whereIn('id', $ids)->whereNull('deleted_at');
                if(!$comments->exists()) {
                    throw new \Exception('Không tìm thấy bình luận hợp lệ để xoá.', 404);
                }
                Cache::tags(array_merge(array_map(fn($id) => "comment_id_$id", $ids)))->flush();
                $comments->delete();

            }
            else {
                $comment = $this->model::find($ids);
                if(!$comment) {
                    throw new \Exception('Không tìm thấy bình luận hợp lệ để xoá', 404);
                }
                $comment->delete();
                Cache::tags(["comment_id_$ids"])->flush();
            }

        });
    }

    public function getChildrenComment($children) {
        $host = env('APP_URL');

        $comments = $children->map(function ($child) use ($host) {
            $imgs = [];
            // $decodedImgs = json_decode(json_decode($child->imgs, true), true);

            // if (is_array($decodedImgs) && count($decodedImgs) > 0) {
            //     foreach ($decodedImgs as $img) {
            //         $imgs[] = $host . $img;
            //     }
            // }

            return [
                'id'   => $child->id,
                'code' => $child->code,
                'name_user' => $child->user->name,
                'img_user' => $host . $child->user->img,
                'email_user' => $child->user->email,
                'star' => $child->star,
                'created_at' => Carbon::parse($child->created_at)->format('Y-m-d H:i:s'),
                'content' => $child->content,
                'imgs' => $imgs,
                'likes' => $child->likes,
                'dislikes' => $child->dislikes,
            ];
        });

        return $comments;
    }
    public function getDetailComment($id, $page) {

        $comment_key = "comment_$id";
        if ($page == 1) {
            $comment = Cache::tags(['comments', "comment_id_$id"])->get($comment_key);
            if ($comment) {
                return $comment;
            }
        }

        $comment = $this->model::with([
            'user' => function($query) {
                $query->select('id','code', 'name', 'email', 'img');
            },
            'product'])->find($id);
        if (!$comment) {
            throw new \Exception("Không tìm thấy bình luận phù hợp yêu cầu", 404);
        }

        $host = env('APP_URL');
        $children = $comment->children()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // $imgs = [];
        // foreach(json_decode(json_decode($comment->imgs, true), true) as $img) {
        //     $imgs[] = $host.$img;
        // }
        if($page == 1) {
            $dataComment = [
                'id'   => $comment->id,
                'code' => $comment->code,
                'product_id'=> $comment->product_id,
                'user_id'=> $comment->user_id,
                'name_user' => $comment?->user?->name,
                'img_user' => $host . $comment?->user?->img,
                'email_user' => $comment?->user?->email,
                'star' => $comment->star,
                'created_at' => Carbon::parse($comment->created_at)->format('Y-m-d H:i:s'),
                'content' => $comment->content,
                'imgs' => json_decode($comment->imgs, true),
                'likes' => $comment->likes,
                'dislikes' => $comment->dislikes,
                'feedbacks' => $this->getChildrenComment($children),
            ];

            Cache::tags(['comments', "comment_id_$id"])->put($comment_key, $dataComment, 600);
            return $dataComment;
        }


        return $this->getChildrenComment($children);

    }

    public function getListCommentDelete($start, $end) {
        $count = $end - $start;
        $comments = $this->model::skip($start)->take($count)
        ->select('id', 'code', 'likes', 'star', 'content', 'deleted_at')
        ->latest()
        ->onlyTrashed()
        ->get();

        if ($comments->isEmpty()) {
            throw new \Exception("Không tìm thấy bình luận trong khoảng yêu cầu", 404);
        }

        $comments =  $comments->map(function($comment)  {
            return [
                'id' => $comment->id,
                'code' => $comment->code,
                'like' => $comment->likes,
                'star' => $comment->star,
                'content' => $comment->content,
                'deleted_at' => Carbon::parse($comment->deleted_at)->format('Y-m-d H:i:s')
            ];
        });
        return $comments;
    }

    public function forceDelete($id) {
        $comment = $this->model::onlyTrashed()->find($id);
        if(!$comment) {
            throw new \Exception('Không tìm thấy bình luận', 404);
        }
        $comment->forceDelete();
    }

    public function recoverCommentDelete($id) {
        $comment = $this->model::onlyTrashed()
        ->select('id', 'code', 'likes', 'star', 'content', 'created_at')
        ->onlyTrashed()
        ->find($id);

        if (!$comment) {
            throw new \Exception("Không tìm thấy bình luận phù hợp yêu cầu", 404);
        }
        $comment->restore();
        $response = [
            'id' => $comment->id,
            'code' => $comment->code,
            'created_at' => Carbon::parse($comment->created_at)->format('y-m-d H:m:s'),
            'like' => $comment->likes,
            'star' => $comment->star,
            'content' => $comment->content

        ];
        return $response;
    }
}

