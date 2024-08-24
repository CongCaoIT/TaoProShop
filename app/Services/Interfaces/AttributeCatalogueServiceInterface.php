<?php

namespace App\Services\Interfaces;

interface AttributeCatalogueServiceInterface
{
    public function paginate($request, $languageId);
}
