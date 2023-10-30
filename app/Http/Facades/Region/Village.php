<?php

namespace App\Http\Facades\Region;

use App\Http\Facades\MessageFixer;
use Illuminate\Support\Facades\Http;

class Village extends Init
{
    public static function get($districtId)
    {
        try {
            $villages = Http::get(self::api . "villages/$districtId.json");

            if (!$villages->successful() || $villages->status() != self::HTTP_OK) {
                return null;
            }

            return $villages->json();
        } catch (\Throwable $th) {
            return null;
        }
    }

    public static function show($id)
    {
        try {
            $villag = Http::get(self::api . "village/$id.json");

            if (!$villag->successful() || $villag->status() != self::HTTP_OK) {
                return null;
            }

            return $villag->json();
        } catch (\Throwable $th) {
            return null;
        }
    }
}
