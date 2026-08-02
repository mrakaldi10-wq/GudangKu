@extends('layouts.app')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Laporan</div>
                <h2 class="page-title">Barang Pending</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="#" class="btn btn-secondary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                        <i class="ti ti-filter icon"></i> Filter
                    </a>
                    <a href="{{ route('barang-pending.laporan.pdf', ['from_date' => request()->query('from_date'), 'to_date' => request()->query('to_date')]) }}"
                        target="_blank" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="ti ti-file-export icon"></i> PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12 col-lg-4">
                <form action="" method="get">
                    <div class="input-icon mb-3">
                        <input type="search" value="{{ request()->query('keyword') }}" class="form-control w-100" name="keyword" placeholder="Search…">
                        <span class="input-icon-addon"><i class="icon ti ti-search"></i></span>
                    </div>
                </form>
                @if (request()->query('from_date'))
                <div class="mb-3">
                    Filters
                    <span class="badge bg-cyan text-cyan-fg">Dari Tgl {{ request()->query('from_date') }}</span>
                    <span class="badge bg-cyan text-cyan-fg">Sampai {{ request()->query('to_date') }}</span>
                    <a class="ms-2 text-reset text-secondary" href="{{ route('barang-pending.laporan') }}">Reset</a>
                </div>
                @endif
            </div>
        </div>

        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Total : {{ $barangPendings->count() }} transaksi
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter table-mobile-md card-table">
                            <thead>
                                <tr>
                                    <th class="w-1">No</th>
                                    <th>Tgl Pending</th>
                                    <th>No. Transaksi</th>
                                    <th>Pelanggan</th>
                                    <th class="text-center">Total Qty</th>
                                    <th class="text-end">Total Harga</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($barangPendings as $row)
                                <tr>
                                    <td class="text-secondary align-text-top" data-label="No">{{ $loop->iteration }}</td>
                                    <td class="align-text-top" data-label="Tgl Pending">{{ $row->tgl_pending }}</td>
                                    <td class="align-text-top" data-label="No. Transaksi">
                                        <a href="{{ route('barang-pending.show', $row->id) }}">{{ $row->no_transaksi }}</a>
                                    </td>
                                    <td class="align-text-top" data-label="Pelanggan">{{ optional($row->pelanggan)->nama_pelanggan ?? '-' }}</td>
                                    <td class="align-text-top text-start text-lg-center" data-label="Total Qty">{{ $row->total_qty }}</td>
                                    <td class="align-text-top text-start text-lg-end" data-label="Total Harga">Rp. {{ number_format($row->total_harga) }}</td>
                                    <td class="align-text-top" data-label="Keterangan">{{ $row->keterangan ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No data found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" name="from_date" value="{{ old('from_date', request()->from_date) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" name="to_date" value="{{ old('to_date', request()->to_date) }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-secondary ms-auto">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection