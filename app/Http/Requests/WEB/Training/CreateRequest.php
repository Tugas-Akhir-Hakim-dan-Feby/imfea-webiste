<?php

namespace App\Http\Requests\WEB\Training;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            "image_thumbnail" => "required|image|mimes:png,jpg,jpeg"
        ];
    }

    public function attributes()
    {
        return [
            "title" => "judul pelatihan",
            "content" => "konten pelatihan",
            "image_thumbnail" => "thumbnail",
        ];
    }
}
