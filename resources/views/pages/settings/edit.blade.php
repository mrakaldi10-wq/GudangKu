@extends('layouts.app')

@section('content')
<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Akun Saya
                </div>
                <h2 class="page-title">
                    Settings
                </h2>
            </div>
        </div>
    </div>
</div>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">

        @if (session('status') === 'password-updated')
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <i class="ti ti-check alert-icon"></i>
                        </div>
                        <div>
                            Password berhasil diperbarui.
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            </div>
        </div>
        @endif

        <div class="row row-deck row-cards">
            <div class="col-12 col-lg-8">
                <div class="card card-md">
                    <form action="{{ route('user-password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h3 class="card-title">Ubah Password</h3>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12">

                                    <div class="mb-3">
                                        <label class="form-label required">Password Saat Ini</label>
                                        <input type="password" name="current_password"
                                            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                            autofocus>
                                        @error('current_password', 'updatePassword')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Password Baru</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                                        @error('password', 'updatePassword')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Konfirmasi Password Baru</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Simpan Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection