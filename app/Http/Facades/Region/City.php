<?php

namespace App\Http\Facades\Region;

use App\Http\Facades\MessageFixer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class City extends Init
{
    public static function get($provinceId)
    {
        try {
            $regencies = Http::get(self::api . "regencies/$provinceId.json");

            if (!$regencies->successful() || $regencies->status() != self::HTTP_OK) {
                return null;
            }

            return $regencies->json();
        } catch (\Throwable $th) {
            return null;
        }
    }

    public static function show($id)
    {
        try {
            $regency = Http::get(self::api . "regency/$id.json");

            if (!$regency->successful() || $regency->status() != self::HTTP_OK) {
                return null;
            }

            return $regency->json();
        } catch (\Throwable $th) {
            return null;
        }
    }
}
