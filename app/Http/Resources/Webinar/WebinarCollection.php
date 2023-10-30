<?php

namespace App\Http\Resources\Webinar;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WebinarCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];

        foreach ($this as $webinar) {
            $data[] = [
                "id" => $webinar->id,
                "title" => $webinar->title,
                "slug" => $webinar->slug,
                "description" => $webinar->description,
                "url" => url('webinar/meet/' . $webinar->slug),
                "status" => $webinar->status,
                "thumbnail" => $webinar->image,
                "author" => $webinar->author->name,
                "activity_date" => $webinar->activity_date,
                "activity_time" => $webinar->activity_time,
                "created_at" => $webinar->created_at,
                "updated_at" => $webinar->updated_at,
            ];
        }

        return $data;
    }
}
