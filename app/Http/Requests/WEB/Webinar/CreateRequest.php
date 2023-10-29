<?php

namespace App\Http\Requests\WEB\Webinar;

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
            "description" => "required",
            "url" => "required|url",
            "activity_time" => "required",
            "activity_date" => "required|date"
        ];
    }

    public function attributes()
    {
        return [
            "title" => "judul webinar",
            "description" => "deskripsi webinar",
            "url" => "url webinar",
            "activity_time" => "waktu kegiatan",
            "activity_date" => "tanggal kegiatan"
        ];
    }
}
