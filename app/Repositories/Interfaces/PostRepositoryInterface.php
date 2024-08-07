<?php

namespace App\Repositories\Interfaces;

interface PostRepositoryInterface
{
    public function getPostById($id = 0, $language_id = 0);
}
