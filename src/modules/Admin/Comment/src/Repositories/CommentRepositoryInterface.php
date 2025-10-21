<?php

namespace Modules\Admin\Comment\src\Repositories;
use App\Repositories\RepositoryInterface;

interface CommentRepositoryInterface extends RepositoryInterface {

    public function getListComment($start, $end);

    public function findComment($page, $code, $count);

    public function deleteComment($ids);

    public function getDetailComment($id, $page);

    public function getListCommentDelete($start, $end);

    public function forceDelete($id);

    public function recoverCommentDelete($id);
}
