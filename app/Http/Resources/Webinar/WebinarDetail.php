<?php

namespace App\Http\Resources\Webinar;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebinarDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,
            "description" => $this->description,
            "url" => url('webinar/meet/' . $this->slug),
            "status" => $this->status,
            "thumbnail" => url($this->thumbnail),
            "author" => $this->author->name,
            "activity_date" => $this->activity_date,
            "activity_time" => $this->activity_time,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];;
    }
}
