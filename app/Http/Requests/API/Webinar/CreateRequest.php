<?php

namespace App\Http\Requests\API\Webinar;

use App\Http\Facades\MessageFixer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

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
            "thumbnail_webinar" => "image|mimes:png,jpg,jpeg",
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
            "thumbnail_webinar" => "thumbnail webinar",
            "activity_time" => "waktu kegiatan",
            "activity_date" => "tanggal kegiatan"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'status' => MessageFixer::WARNING,
            'message' => $validator->errors(),
            'status_code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }
}
