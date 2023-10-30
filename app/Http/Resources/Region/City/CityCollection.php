<?php

namespace App\Http\Resources\Region\City;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];

        foreach ($this as $city) {
            $data[] = [
                "id" => $city["id"],
                "province_id" => $city["province_id"],
                "name" => $city["name"]
            ];
        }

        return $data;
    }
}
