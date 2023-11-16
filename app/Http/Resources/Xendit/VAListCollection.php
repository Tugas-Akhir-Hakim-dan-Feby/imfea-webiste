<?php

namespace App\Http\Resources\Xendit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VAListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];

        foreach ($this as $list) {
            $data[] = [
                "name" => $list["name"],
                "code" => $list["code"],
            ];
        }

        return $data;
    }
}
