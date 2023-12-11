<?php

namespace App\Http\Requests\WEB\Member;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "work_type_id" => "required|exists:work_types,id",
            "province_id" => "required",
            "city_id" => "required",
            "nin" => "required|numeric|min:16",
            "gender" => "required",
            "place_birth" => "required",
            "date_birth" => "required",
            "citizenship" => "required",
            "address" => "required",
            "postal_code" => "required|max:6",
            "phone" => "required|numeric|min:12",
            "image_pas_photo" => "required|image|mimes:png,jpg,jpeg",
            "document_cv" => "required|file|mimes:pdf",
        ];
    }

    public function attributes()
    {
        return [
            "work_type_id" => "jenis pekerjaan",
            "province_id" => "provinsi",
            "city_id" => "kota / kabupaten",
            "nin" => "nik / no. ktp",
            "gender" => "jenis kelamin",
            "place_birth" => "tempat lahir",
            "date_birth" => "tanggal lahir",
            "citizenship" => "kewarganegaraan",
            "address" => "alamat",
            "postal_code" => "kode pos",
            "phone" => "no. telepon",
            "image_pas_photo" => "pas foto / foto profil",
            "document_cv" => "cv / daftar riwayat hidup",
        ];
    }
}
