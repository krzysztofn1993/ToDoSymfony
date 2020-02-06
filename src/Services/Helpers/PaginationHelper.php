<?php

namespace App\Services\Helpers;

class PaginationHelper
{
    public static function pagesToDisplay(int $elementsCount, int $elementsPerPage)
    {
        return $pagesToDisplay = (int) ($elementsCount % $elementsPerPage
            ? $elementsCount / $elementsPerPage
            : $elementsCount / $elementsPerPage - 1);
    }
}
