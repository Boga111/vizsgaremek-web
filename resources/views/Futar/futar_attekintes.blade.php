@extends('Layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="text-center">Futár panel</h2>

    @if(session('siker')) <div class="alert alert-success text-center" style="font-size: 130%;">{{ session('siker') }}</div> @endif
    @if(session('hiba')) <div class="alert alert-danger text-center" style="font-size: 130%;">{{ session('hiba') }}</div> @endif

    <h5 class="mt-4">Elvállalható (kész) rendelések</h5>
    @forelse($elvallalhato as $r)
        <div class="card p-3 mb-3">
            <b>#{{ $r->rendeles_id }}</b> • {{ $r->vegosszeg }} Ft • {{ $r->fiz_mod }} <br>
            <b>Cím:</b> {{ $r->cim }}
            <div class="mt-2">
                <a class="btn btn-sm btn-primary" style="font-size: 102%;" href="/futar/cimek">Megnyitom</a>
            </div>
        </div>
    @empty
        <div class="alert alert-danger" style="max-width: 350px;">
        <p style="font-size: 110%; text-align: center; margin: auto;">Nincs most elvállalható rendelés</p>
        </div>
    @endforelse
</div>
@endsection
