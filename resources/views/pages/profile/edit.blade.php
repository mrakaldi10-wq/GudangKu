@extends('layouts.app')

@php
$user = auth()->user();
$initials = collect(explode(' ', trim($user->name)))
->filter()
->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
->take(2)
->implode('');

$roleMap = [
'admin' => ['label' => 'Admin Gudang', 'badge' => 'bg-blue-lt text-blue', 'avatar' => 'bg-blue'],
'atasan' => ['label' => 'Atasan / Owner', 'badge' => 'bg-purple-lt text-purple', 'avatar' => 'bg-purple'],
];
$roleInfo = $roleMap[$user->role] ?? ['label' => ucfirst($user->role), 'badge' => 'bg-secondary-lt text-secondary', 'avatar' => 'bg-secondary'];
@endphp

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
                    Profile
                </h2>
            </div>
        </div>
    </div>
</div>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">

        @if (session('status') === 'profile-information-updated')
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <i class="ti ti-check alert-icon"></i>
                        </div>
                        <div>
                            Profile berhasil diperbarui.
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            </div>
        </div>
        @endif

        <div class="row row-deck row-cards">

            <!-- Kartu ringkasan profile -->
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body text-center py-4" style="background: linear-gradient(135deg, var(--tblr-primary) 0%, #4263eb 100%); border-radius: var(--tblr-card-border-radius) var(--tblr-card-border-radius) 0 0;">
                        <span class="avatar avatar-xl rounded-circle {{ $roleInfo['avatar'] }} text-white"
                            style="font-size: 1.75rem; font-weight: 600; border: 3px solid rgba(255,255,255,.6);">
                            {{ $initials ?: '?' }}
                        </span>
                    </div>
                    <div class="card-body text-center">
                        <h3 class="m-0 mb-1">{{ $user->name }}</h3>
                        <div class="text-secondary mb-3">{{ $user->email }}</div>
                        <span class="badge {{ $roleInfo['badge'] }}">{{ $roleInfo['label'] }}</span>
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex align-items-center">
                            <i class="ti ti-calendar-event text-secondary me-3"></i>
                            <div>
                                <div class="text-secondary small">Bergabung Sejak</div>
                                <div class="fw-medium">{{ $user->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center">
                            <i class="ti ti-mail text-secondary me-3"></i>
                            <div>
                                <div class="text-secondary small">Email</div>
                                <div class="fw-medium">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center">
                            <i class="ti ti-shield-lock text-secondary me-3"></i>
                            <div>
                                <div class="text-secondary small">Keamanan Akun</div>
                                <a href="{{ route('settings.edit') }}" class="fw-medium">Ubah password &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form edit profile -->
            <div class="col-12 col-lg-8">
                <div class="card card-md">
                    <form action="{{ route('user-profile-information.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h3 class="card-title">Informasi Profile</h3>
                            <div class="card-subtitle">Perbarui nama dan alamat email akun kamu</div>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12">

                                    <div class="mb-3">
                                        <label class="form-label required">Nama</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-user"></i></span>
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                                class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror"
                                                autofocus>
                                        </div>
                                        @error('name', 'updateProfileInformation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                                class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror">
                                        </div>
                                        @error('email', 'updateProfileInformation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label">Role</label>
                                        <input type="text" value="{{ $roleInfo['label'] }}" class="form-control" disabled readonly>
                                        <small class="form-hint">Role hanya dapat diubah oleh administrator sistem.</small>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection