<?php

namespace App\Repositories\Interfaces;

interface AttributeRepositoryInterface
{
    public function getAttributeById($id = 0, $language_id = 0);
}
