<?php

namespace App\Repositories\Interfaces;

interface AttributeCatalogueRepositoryInterface
{
    public function getAttributeCatalogueById($id = 0, $language_id = 0);
}
