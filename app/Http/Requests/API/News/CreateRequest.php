<?php

namespace App\Http\Requests\API\News;

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
            "content" => "required",
            "image_thumbnail" => "required|image|mimes:png,jpg,jpeg"
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
