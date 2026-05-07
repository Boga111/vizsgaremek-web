@extends('Layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="text-center">Elvállalható címek</h2>

    @if(session('hiba'))
        <div class="alert alert-danger text-center" style="font-size: 130%;">{{ session('hiba') }}</div>
    @endif

    @if(session('siker'))
        <div class="alert alert-success text-center" style="font-size: 130%;">{{ session('siker') }}</div>
    @endif

    @forelse($cimek as $r)
        <div class="card p-3 mb-3">
            <h5>#{{ $r->rendeles_id }} • {{ $r->vegosszeg }} Ft • {{ $r->fiz_mod }}</h5>
            <p><b>Indulás:</b> {{ $r->etterem_cim }}</p>
            <p><b>Cél cím:</b> {{ $r->cim ?? '-' }}</p>
            <p><b>Megjegyzés:</b> {{ $r->megjegyzes ?? '-' }}</p>

            @if($r->cim)
                <div class="ratio ratio-16x9 mb-3">
                    <iframe
                        src="https://www.google.com/maps?q={{ urlencode($r->cim) }}&output=embed"
                        loading="lazy">
                    </iframe>
                </div>
            @endif

            <div class="d-grid gap-2">
                <a href="{{ $r->utvonal_link }}" target="_blank" class="btn btn-primary">
                    Útvonal megnyitása
                </a>

                <form method="POST" action="/futar/rendeles/{{ $r->rendeles_id }}/elvallal">
                    @csrf
                    <button class="btn btn-success w-100">Elvállalom</button>
                </form>
            </div>
        </div>
    @empty
        <div class="alert alert-danger" style="max-width: 350px;">
        <p style="font-size: 110%; text-align: center; margin: auto;">Nincs elvállalható cím.</p>
        </div>
    @endforelse
</div>
@endsection
