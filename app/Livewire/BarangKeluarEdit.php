<?php

namespace App\Livewire;

use App\Models\Barang;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\BarangKeluar;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BarangKeluarEdit extends Component
{
    public Collection $inputs;
    public $barangKeluar;

    public $grandTotal;
    public $totalQty;
    public $tglKeluar;
    public $noTransaksi;
    public $pelangganId;

    #[Computed]
    public function barangs()
    {
        return Barang::all()->sortBy('nama_barang');
    }

    #[Computed]
    public function pelanggans()
    {
        return Pelanggan::all()->sortBy('nama_pelanggan');
    }

    public function mount($barangKeluar)
    {
        $this->barangKeluar = $barangKeluar;
        // $this->resetInputFields();
        foreach ($this->barangKeluar->barangKeluarDetails as $key => $value) {
            if ($key == 0) {
                $this->fill([
                    'inputs' => collect([
                        [
                            'barang_id' => $value->barang_id,
                            'harga' => $value->harga,
                            'qty' => $value->qty,
                            'total_harga' => $value->total_harga,
                            'stok' => $value->barang->stok,
                        ]
                    ]),
                ]);
            } else {
                $this->inputs->push([
                    'barang_id' => $value->barang_id,
                    'harga' => $value->harga,
                    'qty' => $value->qty,
                    'total_harga' => $value->total_harga,
                    'stok' => $value->barang->stok,
                ]);
            }
        }

        $this->total();
        $this->tglKeluar = $this->barangKeluar->tgl_keluar;
        $this->noTransaksi = $this->barangKeluar->no_transaksi;
        $this->pelangganId = $this->barangKeluar->pelanggan_id;
    }

    public function addInput()
    {
        $this->inputs->push([
            'barang_id' => '',
            'harga' => '',
            'qty' => 1,
            'total_harga' => '',
            'stok' => '',
        ]);
    }

    public function removeInput($key)
    {
        $this->inputs->pull($key);
        $this->total();
    }

    private function resetInputFields()
    {
        $this->fill([
            'inputs' => collect([
                [
                    'barang_id' => '',
                    'harga' => '',
                    'qty' => 1,
                    'total_harga' => '',
                    'stok' => '',
                ]
            ]),
        ]);
    }

    public function change($key)
    {

        if (!empty($this->inputs[$key]['barang_id'])) {
            $barang = Barang::find($this->inputs[$key]['barang_id']);

            if ($barang) {
                $this->inputs[$key] = [
                    'barang_id' => $barang->id,
                    'harga' => $barang->harga,
                    'total_harga' => ($this->inputs[$key]['qty']) * $barang->harga,
                    'qty' => $this->inputs[$key]['qty'],
                    'stok' => $barang->stok,
                ];
            } else {
                $this->inputs[$key] = [
                    'barang_id' => '',
                    'harga' => 0,
                    'total_harga' => 0,
                    'qty' => 1,
                    'stok' => 0,
                ];
            }
            $this->total();
        }
    }

    public function total()
    {
        $subTotal = 0;
        $totalQty = 0;
        foreach ($this->inputs as $input) {
            if (!empty($input['barang_id'])) {
                $subTotal += $input['total_harga'];
                $totalQty += $input['qty'];
            }
        }
        $this->grandTotal = $subTotal;
        $this->totalQty = $totalQty;
    }

    public function rules()
    {
        $rules = [
            'inputs.*.barang_id' => ['required', 'exists:barangs,id'],
            'pelangganId' => ['required', 'exists:pelanggans,id'],
        ];

        foreach ($this->inputs as $key => $value) {
            if (!empty($this->inputs[$key]['barang_id'])) {

                $rules['inputs.' . $key . '.qty'] = ['required', 'numeric', 'min:1', 'max:' . $value['stok']];
            }
        }

        return $rules;
    }

    protected $messages = [
        'inputs.*.barang_id.required' => 'Barang wajib dipilih.',
        'inputs.*.barang_id.exists' => 'Barang yang dipilih tidak valid.',
        'inputs.*.qty.required' => 'Qty wajib diisi.',
        'inputs.*.qty.max' => 'Qty tidak boleh lebih dari stok yang tersedia.',
        'inputs.*.qty.min' => 'Qty tidak boleh kurang dari 1.',
        'inputs.*.qty.numeric' => 'Qty harus berupa angka.',
        'pelangganId.required' => 'Pelanggan wajib dipilih.',
        'pelangganId.exists' => 'Pelanggan yang dipilih tidak valid.',
    ];

    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();


            foreach ($this->barangKeluar->barangKeluarDetails as $value) {
                $value->barang->increment('stok', $value->qty);
            }
            $this->barangKeluar->barangKeluarDetails()->delete();

            $this->barangKeluar->update([
                'no_transaksi' => $this->noTransaksi,
                'tgl_keluar' => $this->tglKeluar,
                'pelanggan_id' => $this->pelangganId,
                'total_qty' => $this->totalQty,
                'total_harga' => $this->grandTotal,
            ]);


            foreach ($this->inputs as $input) {
                $barangKeluarDetails = $this->barangKeluar->barangKeluarDetails()->create([
                    'barang_id' => $input['barang_id'],
                    'harga' => $input['harga'],
                    'qty' => $input['qty'],
                    'total_harga' => $input['total_harga'],
                ]);

                $barangKeluarDetails->barang->decrement('stok', $input['qty']);
            }

            DB::commit();
            $this->resetInputFields();

            session()->flash('success', 'Data Updated Successfully.');

            return redirect()->route('barang-keluar.show', $this->barangKeluar->id);
        } catch (\Throwable $e) {

            DB::rollBack();
            session()->flash('error', " ERROR MESSAGE: " . $e->getMessage());
            return redirect()->route('barang-keluar.edit', $this->barangKeluar->id);
        }
    }

    public function render()
    {
        return view('livewire.barang-keluar-edit');
    }
}
