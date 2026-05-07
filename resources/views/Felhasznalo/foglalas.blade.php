@extends('Layouts.app')
@section('content')

<div class="container mt-5">

    <h2 class="text-center mb-4">Asztalfoglalás</h2>

    @if(session('siker'))
        <div class="alert alert-success text-center" style="font-size: 130%;">{{ session('siker') }}</div>
    @endif
    @if(session('hiba'))
        <div class="alert alert-danger text-center" style="font-size: 130%;">{{ session('hiba') }}</div>
    @endif

    <div class="text-center mb-3">
        <span class="badge bg-success">Szabad</span>
        <span class="badge bg-danger">Foglalt</span>
    </div>

    <div class="card mx-auto mb-4" style="max-width: 400px;">
        <div class="card-body text-center">
            <h5 class="card-title mt-3">Asztal méretek</h5>
            <p class="mb-1"><strong>A sor:</strong> 2 személyes</p>
            <p class="mb-1"><strong>B sor:</strong> 4 személyes</p>
            <p class="mb-1"><strong>C sor:</strong> 6 személyes</p>
            <p class="mb-1"><strong>D sor:</strong> 8 személyes</p>
            <p class="mb-0"><strong>E sor:</strong> 10 személyes</p>
        </div>
    </div>

    <div class="alert alert-info text-center mx-auto mb-4" style="max-width: 500px; font-size: 130%;">
        <strong>Foglalási időkorlát:</strong><br>
        Az <strong>A és B sorban</strong> lévő asztalok <strong>2 órára</strong> foglalhatók.<br>
        A <strong>C, D és E sorban</strong> lévő asztalok <strong>3 órára</strong> foglalhatók.
    </div>

    <form method="POST" action="/foglalas">
        @csrf

        <div class="text-center mb-4">

            @php
                $rows = range('A','E');
                $cols = range(1,5);
            @endphp

            @foreach($rows as $row)
                <div class="d-flex justify-content-center mb-2">
                    @foreach($cols as $col)
                        @php
                            $asztal = $row.$col;
                            $foglalt = in_array($asztal, $foglaltAsztalok ?? []);
                        @endphp
                        <div class="m-1">
                            <input type="radio"
                                   name="asztalszam"
                                   value="{{ $asztal }}"
                                   id="{{ $asztal }}"
                                   {{ $foglalt ? 'disabled' : '' }}
                                   hidden>

                            <label for="{{ $asztal }}"
                                   class="btn {{ $foglalt ? 'btn-danger' : 'btn-success' }}">
                                {{ $asztal }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach

        </div>

        <div class="text-center mt-3">
            <strong>Kiválasztott asztal: </strong>
            <span id="kivalasztottAsztal">–</span>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-md-4">

                <div class="mb-3">
                    <label>Időpont</label>
                    <input type="datetime-local"
                           name="idopont"
                           class="form-control"
                           min="{{ now()->format('Y-m-d\TH:i') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label>Hány fő?</label>
                    <input type="number"
                           name="fo_db"
                           class="form-control"
                           min="1"
                           max="10"
                           required>
                </div>

                <button class="btn btn-success w-100 mb-3">
                    Foglalás megerősítése
                </button>

            </div>
        </div>

    </form>

</div>

<script src="{{ asset('assets/js/foglalas.js') }}"></script>
@endsection
