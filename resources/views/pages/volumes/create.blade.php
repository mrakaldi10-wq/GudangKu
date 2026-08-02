@extends('layouts.app')

@section('content')
    <div class="page-header d-print-none ">
        <div class="container-xl ">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Master Data</div>
                    <h2 class="page-title">Tambah Volume</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <x-alert-success />
            <x-alert-error />

            <div class="row row-deck row-cards">
                <div class="col-12 col-lg-6">
                    <div class="card card-md">
                        <form action="{{ route('volumes.store') }}" method="POST">
                            @csrf
                            <div class="card-header">
                                <a href="{{ route('volumes.index') }}" class="btn btn-icon">
                                    <i class="ti ti-chevrons-left"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label required">Nama Volume</label>
                                    <input type="text" name="nama_volume" value="{{ old('nama_volume') }}"
                                        class="form-control @error('nama_volume') is-invalid @enderror"
                                        placeholder="Contoh: 100 ml, 5 L, 250 gr" autofocus>
                                    @error('nama_volume')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('volumes.index') }}" class="btn btn-outline-secondary w-25">Cancel</a>
                                <button type="submit" class="btn btn-primary ms-3 w-25">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
