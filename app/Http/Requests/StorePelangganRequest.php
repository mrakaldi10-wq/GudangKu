<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePelangganRequest extends FormRequest
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
            'nama_pelanggan' => ['required'],
            'email' => ['required', 'email', 'unique:pelanggans'],
            'notelp' => ['required'],
            'alamat' => ['nullable'],
        ];
    }

    /**
     * Get the custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_pelanggan.required' => 'Nama Pelanggan wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
            'notelp.required' => 'No. Telepon wajib diisi.',
        ];
    }
}
