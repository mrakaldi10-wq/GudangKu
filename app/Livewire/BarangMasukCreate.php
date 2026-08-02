<?php

namespace App\Livewire;

use App\Models\Barang;
use App\Models\Pemasok;
use Livewire\Component;
use App\Models\BarangMasuk;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BarangMasukCreate extends Component
{
    public Collection $inputs;

    public $grandTotal;
    public $totalQty;
    public $tglMasuk;
    public $noTransaksi;
    public $pemasokId;

    #[Computed]
    public function barangs()
    {
        return Barang::all()->sortBy('nama_barang');
    }

    #[Computed]
    public function pemasoks()
    {
        return Pemasok::all()->sortBy('nama_pemasok');
    }

    public function addInput()
    {
        $this->inputs->push([
            'barang_id' => '',
            'harga' => '',
            'qty' => 1,
            'total_harga' => '',
            'stok' => '',
            'tanggal_expired' => '',
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
                    'tanggal_expired' => '',
                ]
            ]),
        ]);
    }

    public function mount()
    {
        $this->resetInputFields();
        $this->noTransaksi = 'INV-' . date('Ymd') . '-' . mt_rand(1000, 9999);
        $this->tglMasuk = date('Y-m-d');
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
                    'tanggal_expired' => $this->inputs[$key]['tanggal_expired'] ?? '',
                ];
            } else {
                $this->inputs[$key] = [
                    'barang_id' => '',
                    'harga' => 0,
                    'total_harga' => 0,
                    'qty' => 1,
                    'stok' => 0,
                    'tanggal_expired' => '',
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
            'pemasokId' => ['required', 'exists:pemasoks,id'],
        ];

        foreach ($this->inputs as $key => $value) {
            if (!empty($this->inputs[$key]['barang_id'])) {
                $rules['inputs.' . $key . '.qty'] = ['required', 'numeric', 'min:1'];
                $rules['inputs.' . $key . '.tanggal_expired'] = ['nullable', 'date'];
            }
        }

        return $rules;
    }

    protected $messages = [
        'inputs.*.barang_id.required' => 'This field is required.',
        'inputs.*.qty.required' => 'This field is required.',
        'inputs.*.qty.max' => 'The quantity must not be greater than the stock.',
        'inputs.*.qty.min' => 'The quantity must not be less than 1.',
        'inputs.*.qty.numeric' => 'The quantity must be a number.',
        'inputs.*.tanggal_expired.date' => 'Format tanggal tidak valid.',
    ];

    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $barangMasuk = BarangMasuk::create([
                'no_transaksi' => $this->noTransaksi,
                'tgl_masuk' => $this->tglMasuk,
                'pemasok_id' => $this->pemasokId,
                'total_qty' => $this->totalQty,
                'total_harga' => $this->grandTotal,
            ]);

            foreach ($this->inputs as $input) {
                $barangMasukDetails = $barangMasuk->barangMasukDetails()->create([
                    'barang_id' => $input['barang_id'],
                    'harga' => $input['harga'],
                    'qty' => $input['qty'],
                    'total_harga' => $input['total_harga'],
                    'tanggal_expired' => $input['tanggal_expired'] ?: null,
                ]);

                $barangMasukDetails->barang->increment('stok', $input['qty']);

                // Update tanggal expired pada master barang agar tampil di menu Stok Barang
                if (!empty($input['tanggal_expired'])) {
                    $barangMasukDetails->barang->update([
                        'tanggal_expired' => $input['tanggal_expired'],
                    ]);
                }
            }

            DB::commit();
            $this->resetInputFields();

            session()->flash('success', 'Transaction Created Successfully.');

            return redirect()->route('barang-masuk.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('error', " ERROR MESSAGE: " . $e->getMessage());
            return redirect()->route('barang-masuk.create');
        }
    }
    public function render()
    {
        return view('livewire.barang-masuk-create');
    }
}
