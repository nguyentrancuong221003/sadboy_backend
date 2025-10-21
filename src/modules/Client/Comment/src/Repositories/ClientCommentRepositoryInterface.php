<?php

namespace Modules\Client\Comment\src\Repositories;
use App\Repositories\RepositoryInterface;

interface ClientCommentRepositoryInterface extends RepositoryInterface {

    public function addComment($data);

}
