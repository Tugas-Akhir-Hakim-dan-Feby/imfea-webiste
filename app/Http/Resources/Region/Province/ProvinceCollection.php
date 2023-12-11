<?php

namespace App\Http\Resources\Region\Province;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProvinceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];

        foreach ($this as $province) {
            $data[] = [
                "id" => $province["id"],
                "name" => $province["name"]
            ];
        }

        return $data;
    }
}
