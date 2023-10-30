<?php

namespace App\Http\Facades\Region;

use App\Http\Facades\MessageFixer;
use Illuminate\Support\Facades\Http;

class Province extends Init
{
    public static function get()
    {
        try {
            $provinces = Http::get(self::api . 'provinces.json');

            if (!$provinces->successful() || $provinces->status() != self::HTTP_OK) {
                return null;
            }

            return $provinces->json();
        } catch (\Throwable $th) {
            return null;
        }
    }

    public static function show($id)
    {
        try {
            $province = Http::get(self::api . "province/$id.json");

            if (!$province->successful() || $province->status() != self::HTTP_OK) {
                return null;
            }

            return $province->json();
        } catch (\Throwable $th) {
            return null;
        }
    }
}
