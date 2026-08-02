@extends('layouts.app')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Transaksi</div>
                <h2 class="page-title">Detail Barang Pending</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('barang-pending.index') }}" class="btn btn-icon">
                            <i class="ti ti-chevrons-left"></i>
                        </a>
                        <h4 class="card-title ms-2">{{ $barangPending->no_transaksi }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3"><strong>Tanggal Pending</strong></div>
                            <div class="col-md-9">: {{ $barangPending->tgl_pending }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"><strong>No. Transaksi</strong></div>
                            <div class="col-md-9">: {{ $barangPending->no_transaksi }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"><strong>Pelanggan</strong></div>
                            <div class="col-md-9">: {{ optional($barangPending->pelanggan)->nama_pelanggan ?? '-' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3"><strong>Keterangan</strong></div>
                            <div class="col-md-9">: {{ $barangPending->keterangan ?? '-' }}</div>
                        </div>
                        <hr>
                        <h5>Detail Barang</h5>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Barang</th>
                                        <th>Satuan</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangPending->details as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->barang->nama_barang }}</td>
                                        <td>{{ $detail->barang->satuan->nama_satuan }}</td>
                                        <td class="text-center">{{ $detail->qty }}</td>
                                        <td class="text-end">Rp. {{ number_format($detail->harga) }}</td>
                                        <td class="text-end">Rp. {{ number_format($detail->total_harga) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Total</th>
                                        <th class="text-center">{{ $barangPending->total_qty }}</th>
                                        <th></th>
                                        <th class="text-end">Rp. {{ number_format($barangPending->total_harga) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection