<?php

namespace App\Http\Requests\WEB\News;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            "title" => "required",
            "content" => "required",
            "image_thumbnail" => "image|mimes:png,jpg,jpeg"
        ];
    }

    public function attributes()
    {
        return [
            "title" => "judul berita",
            "content" => "konten berita",
            "image_thumbnail" => "thumbnail",
        ];
    }
}
