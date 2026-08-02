@extends('layouts.app')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Transaksi</div>
                <h2 class="page-title">Edit Barang Pending</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <x-alert-success />
        <x-alert-error />

        <div class="row row-deck row-cards">
            <div class="col-12 col-lg-10">
                <div class="card card-md">
                    <form action="{{ route('barang-pending.update', $barangPending->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <a href="{{ route('barang-pending.index') }}" class="btn btn-icon">
                                <i class="ti ti-chevrons-left"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Tanggal Pending</label>
                                        <input type="date" name="tgl_pending" value="{{ old('tgl_pending', $barangPending->tgl_pending) }}"
                                            class="form-control @error('tgl_pending') is-invalid @enderror">
                                        @error('tgl_pending')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">No. Transaksi</label>
                                        <input type="text" name="no_transaksi" value="{{ old('no_transaksi', $barangPending->no_transaksi) }}"
                                            class="form-control @error('no_transaksi') is-invalid @enderror">
                                        @error('no_transaksi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pelanggan</label>
                                        <select name="pelanggan_id" class="form-select @error('pelanggan_id') is-invalid @enderror">
                                            <option value="">Pilih Pelanggan (opsional)</option>
                                            @foreach ($pelanggans as $item)
                                            <option value="{{ $item->id }}" @selected(old('pelanggan_id', $barangPending->pelanggan_id) == $item->id)>{{ $item->nama_pelanggan }}</option>
                                            @endforeach
                                        </select>
                                        @error('pelanggan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <input type="text" name="keterangan" value="{{ old('keterangan', $barangPending->keterangan) }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h4>Detail Barang</h4>
                            <div id="detail-container">
                                @foreach ($barangPending->details as $detail)
                                <div class="row detail-row mb-2">
                                    <div class="col-md-5">
                                        <select name="barang_id[]" class="form-select" required>
                                            <option value="">Pilih Barang</option>
                                            @foreach ($barangs as $item)
                                            <option value="{{ $item->id }}" @selected($detail->barang_id == $item->id)>{{ $item->nama_barang }} ({{ $item->kode }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="qty[]" class="form-control" placeholder="Qty" min="1" required value="{{ $detail->qty }}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="harga[]" class="form-control" placeholder="Harga" min="0" required readonly value="{{ $detail->harga }}">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-icon remove-row">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-2" id="add-row">
                                <i class="ti ti-plus me-1"></i> Tambah Baris
                            </button>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('barang-pending.index') }}" class="btn btn-outline-secondary w-25">Cancel</a>
                            <button type="submit" class="btn btn-primary ms-3 w-25">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom_script')
<script>
    const barangs = @json($barangs);
    const barangOptionsHtml = `<option value="">Pilih Barang</option>` + barangs.map(b => `<option value="${b.id}">${b.nama_barang} (${b.kode})</option>`).join('');

    // Pesan validasi custom (bahasa Indonesia) untuk menggantikan alert bawaan browser
    function setCustomValidationMessages(row) {
        const selectBarang = row.querySelector('select[name="barang_id[]"]');
        const inputQty = row.querySelector('input[name="qty[]"]');
        const inputHarga = row.querySelector('input[name="harga[]"]');

        if (selectBarang) {
            selectBarang.addEventListener('invalid', function() {
                this.setCustomValidity('Silakan pilih barang terlebih dahulu.');
            });
            selectBarang.addEventListener('input', function() {
                this.setCustomValidity('');
            });
        }

        if (inputQty) {
            inputQty.addEventListener('invalid', function() {
                this.setCustomValidity(this.value === '' ? 'Silakan isi jumlah (Qty) barang.' : 'Qty minimal 1.');
            });
            inputQty.addEventListener('input', function() {
                this.setCustomValidity('');
            });
        }

        if (inputHarga) {
            inputHarga.addEventListener('invalid', function() {
                this.setCustomValidity(this.value === '' ? 'Silakan isi harga barang.' : 'Harga tidak boleh kurang dari 0.');
            });
            inputHarga.addEventListener('input', function() {
                this.setCustomValidity('');
            });
        }
    }

    document.querySelectorAll('.detail-row').forEach(setCustomValidationMessages);

    // Isi otomatis harga sesuai data barang yang dipilih
    function fillHargaFromBarang(row) {
        const selectBarang = row.querySelector('select[name="barang_id[]"]');
        const inputHarga = row.querySelector('input[name="harga[]"]');

        if (!selectBarang || !inputHarga) return;

        const barang = barangs.find(b => String(b.id) === String(selectBarang.value));
        inputHarga.value = barang ? barang.harga : '';
    }

    document.getElementById('detail-container').addEventListener('change', function(e) {
        if (e.target.matches('select[name="barang_id[]"]')) {
            fillHargaFromBarang(e.target.closest('.detail-row'));
        }
    });

    document.getElementById('add-row').addEventListener('click', function() {
        const container = document.getElementById('detail-container');
        const newRow = document.createElement('div');
        newRow.className = 'row detail-row mb-2';
        newRow.innerHTML = `
            <div class="col-md-5"><select name="barang_id[]" class="form-select" required>${barangOptionsHtml}</select></div>
            <div class="col-md-3"><input type="number" name="qty[]" class="form-control" placeholder="Qty" min="1" required></div>
            <div class="col-md-3"><input type="number" name="harga[]" class="form-control" placeholder="Harga" min="0" required readonly></div>
            <div class="col-md-1"><button type="button" class="btn btn-danger btn-icon remove-row"><i class="ti ti-trash"></i></button></div>`;
        container.appendChild(newRow);
        setCustomValidationMessages(newRow);
    });

    document.getElementById('detail-container').addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            const rows = document.querySelectorAll('.detail-row');
            if (rows.length > 1) {
                e.target.closest('.detail-row').remove();
            }
        }
    });
</script>
@endpush