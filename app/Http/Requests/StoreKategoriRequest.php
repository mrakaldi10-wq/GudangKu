<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKategoriRequest extends FormRequest
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
            'nama_kategori' => ['required', 'string', 'min:3', 'max:255'],
            'keterangan' => ['nullable', 'string', 'min:3', 'max:255'],
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
            'nama_kategori.required' => 'Nama Kategori wajib diisi.',
            'nama_kategori.min' => 'Nama Kategori minimal 3 karakter.',
            'nama_kategori.max' => 'Nama Kategori maksimal 255 karakter.',
            'keterangan.min' => 'Keterangan minimal 3 karakter.',
            'keterangan.max' => 'Keterangan maksimal 255 karakter.',
        ];
    }
}
