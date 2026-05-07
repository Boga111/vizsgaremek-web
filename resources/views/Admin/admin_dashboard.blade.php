@extends('Layouts.app')
@section('content')

<div class="container mt-5">
    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Rendelések száma</h5>
                <h3>{{ $rendelesekSzama }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Felhasználók száma</h5>
                <h3>{{ $felhasznalokSzama }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Bevétel</h5>
                <h3>{{ $bevetel }} Ft</h3>
            </div>
        </div>
    </div>

    <h5 class="mt-4">Top ételek</h5>
    <canvas id="chart"></canvas>

    <h5 class="mt-5">Napi bevétel (nettó vs bruttó)</h5>
    <canvas id="chartBevetel" class="mb-5"></canvas>
</div>

<script>
    window.chartLabels = {!! json_encode($topEtelek->pluck('termek_nev')) !!};
    window.chartData   = {!! json_encode($topEtelek->pluck('osszes')) !!};

    window.revLabels = {!! json_encode($napiLabels ?? []) !!};
    window.revNetto  = {!! json_encode($napiNetto ?? []) !!};
    window.revBrutto = {!! json_encode($napiBrutto ?? []) !!};
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/diagram.js') }}"></script>

@endsection
