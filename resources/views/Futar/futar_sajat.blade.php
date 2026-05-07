@extends('Layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="text-center">Saját fuvarok</h2>

    @if(session('siker'))
        <div class="alert alert-success text-center" style="font-size: 130%;">{{ session('siker') }}</div>
    @endif

    @if(session('hiba'))
        <div class="alert alert-danger text-center" style="font-size: 130%;">{{ session('hiba') }}</div>
    @endif

    @forelse($fuvarok as $r)
        <div class="card p-3 mb-3">
            <h5>#{{ $r->rendeles_id }} • {{ $r->vegosszeg }} Ft</h5>
            <p><b>Cím:</b> {{ $r->cim ?? $r->szallitasiCim?->cim ?? '-' }}</p>
            <p><b>Állapot:</b> <b>{{ $r->allapot }}</b></p>

            <form method="POST" action="/futar/rendeles/{{ $r->rendeles_id }}/allapot">
                @csrf
                <select name="allapot" class="form-select mb-2" required>
                    @if($r->allapot === 'uton')
                        <option value="uton" selected>Úton</option>
                        <option value="kiszallitva">Kiszállítva</option>
                    @elseif($r->allapot === 'kiszallitva')
                        <option value="kiszallitva" selected>Kiszállítva</option>
                    @endif
                </select>
                <button class="btn btn-primary w-100">Mentés</button>
            </form>
        </div>
    @empty
    <div class="alert alert-danger" style="max-width: 350px;">
        <p style="font-size: 110%; text-align: center; margin: auto;">Nincs saját fuvarod.</p>
    </div>
    @endforelse
</div>
@endsection
