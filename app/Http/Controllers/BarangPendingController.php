<?php

namespace App\Http\Controllers;

use App\Models\BarangPending;
use App\Models\Barang;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class BarangPendingController extends Controller
{
    public function index()
    {
        $filter['search'] = request()->keyword;

        $barangPendings = BarangPending::query()
            ->with(['pelanggan'])
            ->filter($filter)
            ->latest()
            ->paginate(10);

        return view('pages.barang-pending.index', compact('barangPendings'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $barangs  = Barang::all();
        $noTransaksi = 'PND-' . date('YmdHis');
        return view('pages.barang-pending.create', compact('pelanggans', 'barangs', 'noTransaksi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_pending'    => 'required|date',
            'no_transaksi'   => 'required|unique:barang_pendings,no_transaksi',
            'pelanggan_id'   => 'nullable|exists:pelanggans,id',
            'keterangan'     => 'nullable',
            'barang_id'      => 'required|array',
            'barang_id.*'    => 'exists:barangs,id',
            'qty'            => 'required|array',
            'qty.*'          => 'required|numeric|min:1',
            'harga'          => 'required|array',
            'harga.*'        => 'required|numeric|min:0',
        ]);

        $totalQty   = array_sum($validated['qty']);
        $totalHarga = 0;
        foreach ($validated['qty'] as $i => $qty) {
            $totalHarga += $qty * $validated['harga'][$i];
        }

        $pending = BarangPending::create([
            'tgl_pending'  => $validated['tgl_pending'],
            'no_transaksi' => $validated['no_transaksi'],
            'pelanggan_id' => $validated['pelanggan_id'] ?? null,
            'total_qty'    => $totalQty,
            'total_harga'  => $totalHarga,
            'keterangan'   => $validated['keterangan'] ?? null,
        ]);

        foreach ($validated['barang_id'] as $i => $barangId) {
            $qty   = $validated['qty'][$i];
            $harga = $validated['harga'][$i];
            $pending->details()->create([
                'barang_id'   => $barangId,
                'qty'         => $qty,
                'harga'       => $harga,
                'total_harga' => $qty * $harga,
            ]);
        }

        return redirect()->route('barang-pending.index')->with('success', 'Barang Pending berhasil ditambahkan');
    }

    public function show(BarangPending $barangPending)
    {
        $barangPending->load('pelanggan', 'details.barang.satuan');
        return view('pages.barang-pending.show', compact('barangPending'));
    }

    public function edit(BarangPending $barangPending)
    {
        $barangPending->load('details');
        $pelanggans = Pelanggan::all();
        $barangs  = Barang::all();
        return view('pages.barang-pending.edit', compact('barangPending', 'pelanggans', 'barangs'));
    }

    public function update(Request $request, BarangPending $barangPending)
    {
        $validated = $request->validate([
            'tgl_pending'    => 'required|date',
            'no_transaksi'   => 'required|unique:barang_pendings,no_transaksi,' . $barangPending->id,
            'pelanggan_id'   => 'nullable|exists:pelanggans,id',
            'keterangan'     => 'nullable',
            'barang_id'      => 'required|array',
            'barang_id.*'    => 'exists:barangs,id',
            'qty'            => 'required|array',
            'qty.*'          => 'required|numeric|min:1',
            'harga'          => 'required|array',
            'harga.*'        => 'required|numeric|min:0',
        ]);

        $totalQty   = array_sum($validated['qty']);
        $totalHarga = 0;
        foreach ($validated['qty'] as $i => $qty) {
            $totalHarga += $qty * $validated['harga'][$i];
        }

        $barangPending->update([
            'tgl_pending'  => $validated['tgl_pending'],
            'no_transaksi' => $validated['no_transaksi'],
            'pelanggan_id' => $validated['pelanggan_id'] ?? null,
            'total_qty'    => $totalQty,
            'total_harga'  => $totalHarga,
            'keterangan'   => $validated['keterangan'] ?? null,
        ]);

        $barangPending->details()->delete();
        foreach ($validated['barang_id'] as $i => $barangId) {
            $qty   = $validated['qty'][$i];
            $harga = $validated['harga'][$i];
            $barangPending->details()->create([
                'barang_id'   => $barangId,
                'qty'         => $qty,
                'harga'       => $harga,
                'total_harga' => $qty * $harga,
            ]);
        }

        return redirect()->route('barang-pending.index')->with('success', 'Barang Pending berhasil diperbarui');
    }

    public function destroy(BarangPending $barangPending)
    {
        $barangPending->delete();
        return redirect()->route('barang-pending.index')->with('success', 'Barang Pending berhasil dihapus');
    }
}
