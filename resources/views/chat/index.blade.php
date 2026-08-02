@extends('layouts.app')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Chat Internal</h2>
                <div class="text-secondary mt-1">
                    Komunikasi langsung antara Admin dan Atasan tanpa perlu WhatsApp di HP.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        @livewire('chat-box')
    </div>
</div>
@endsection
