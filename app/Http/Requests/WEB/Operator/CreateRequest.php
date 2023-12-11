<?php

namespace App\Http\Requests\WEB\Operator;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "nama" => "required",
            "email" => "required",
            "password" => bcrypt('Password123!'),
        ];
    }
    public function attributes()
    {
        return [
            "nama" => "Nama",
            "email" => "Email",
            "password" => "Password",
        ];
    }
}
