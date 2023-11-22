<?php

namespace App\Http\Requests\WEB\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "topic_id",
            "title",
            "link_video",
            "content",
        ];
    }

    public function attributes()
    {
        return [
            "topic_id" => "topik materi",
            "title" => "judul materi",
            "link_video" => "link video",
            "content" => "konten materi",
        ];
    }
}
