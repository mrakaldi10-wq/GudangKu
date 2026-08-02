<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_barang' => 'required',
            'kode' => 'required|unique:barangs,kode,' . $this->barang->id,
            'satuan_id' => 'required|exists:satuans,id',
            'volume_id' => 'nullable|exists:volumes,id',
            'stok' => 'required|numeric',
            'min_stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar' => 'nullable',
            'keterangan' => 'nullable',
            'tanggal_expired' => 'nullable|date',
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
            'nama_barang.required' => 'Nama Barang wajib diisi.',
            'kode.required' => 'Kode Barang wajib diisi.',
            'kode.unique' => 'Kode Barang sudah digunakan, gunakan kode lain.',
            'satuan_id.required' => 'Satuan wajib dipilih.',
            'satuan_id.exists' => 'Satuan yang dipilih tidak valid.',
            'volume_id.exists' => 'Volume yang dipilih tidak valid.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.numeric' => 'Stok harus berupa angka.',
            'min_stok.required' => 'Minimal Stok wajib diisi.',
            'min_stok.numeric' => 'Minimal Stok harus berupa angka.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'tanggal_expired.date' => 'Tanggal Expired harus berupa tanggal yang valid.',
        ];
    }
}
