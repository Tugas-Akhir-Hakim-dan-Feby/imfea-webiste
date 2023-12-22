<?php

namespace App\Http\Requests\WEB\User\Korwil;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'regional_id' => 'required|exists:regionals,id',
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(request()->id)
            ],
        ];
    }
}
