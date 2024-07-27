<?php

namespace App\Repositories\Interfaces;

interface PostCatalogueRepositoryInterface
{
    public function getPostCatalogueById($id = 0, $language_id = 0);
}
