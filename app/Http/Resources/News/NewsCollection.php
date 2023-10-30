<?php

namespace App\Http\Resources\News;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];

        foreach ($this as $new) {
            $data[] = [
                "id" => $new->id,
                "title" => $new->title,
                "slug" => $new->slug,
                "content" => $new->content,
                "status" => $new->status,
                "thumbnail" => $new->thumbnail,
                "author" => $new->author->name,
            ];
        }

        return $data;
    }
}
