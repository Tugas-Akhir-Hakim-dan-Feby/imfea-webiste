<?php

namespace App\Http\Requests\WEB\Exam;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
            "topic_id" => "required|exists:topics,id",
            "question" => "required",
            "type" => "required|in:0,1",
        ];
    }
}
