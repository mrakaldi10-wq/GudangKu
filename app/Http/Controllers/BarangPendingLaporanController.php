<?php

namespace App\Http\Controllers;

use App\Models\BarangPending;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangPendingLaporanController extends Controller
{
    public function index()
    {
        $barangPendings = $this->filter();
        return view('pages.barang-pending.laporan.index', compact('barangPendings'));
    }

    public function pdf()
    {
        $barangPendings = $this->filter();
        $pdf = Pdf::setOptions(['dpi' => 110])
            ->loadView('pages.barang-pending.laporan.pdf', compact('barangPendings'));
        return $pdf->stream('laporan-barang-pending.pdf');
    }

    public function filter()
    {
        $query = BarangPending::query()->with(['pelanggan', 'details.barang.satuan']);

        if (request()->from_date && request()->to_date) {
            $query->whereBetween('tgl_pending', [request()->from_date, request()->to_date]);
        }

        if (request()->keyword) {
            $search = request()->keyword;
            $query->where(function ($q) use ($search) {
                $q->where('no_transaksi', 'like', '%' . $search . '%')
                    ->orWhereHas('pelanggan', fn($q2) => $q2->where('nama_pelanggan', 'like', '%' . $search . '%'));
            });
        }

        return $query->latest()->get();
    }
}
