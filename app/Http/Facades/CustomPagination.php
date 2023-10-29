<?php

namespace App\Http\Facades;

class CustomPagination
{
    public static function render($paginator)
    {
        return view('components.pagination', compact('paginator'));
    }
}
