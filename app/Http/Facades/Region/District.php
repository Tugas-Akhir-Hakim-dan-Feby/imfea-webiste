<?php

namespace App\Http\Facades\Region;

use App\Http\Facades\MessageFixer;
use Illuminate\Support\Facades\Http;

class District extends Init
{
    public static function get($regencyId)
    {
        try {
            $districts = Http::get(self::api . "districts/$regencyId.json");

            if (!$districts->successful() || $districts->status() != self::HTTP_OK) {
                return null;
            }

            return $districts->json();
        } catch (\Throwable $th) {
            return null;
        }
    }

    public static function show($id)
    {
        try {
            $district = Http::get(self::api . "district/$id.json");

            if (!$district->successful() || $district->status() != self::HTTP_OK) {
                return null;
            }

            return $district->json();
        } catch (\Throwable $th) {
            return null;
        }
    }
}
