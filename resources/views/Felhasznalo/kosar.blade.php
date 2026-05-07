@extends('Layouts.app')
@section('content')

@if ($errors->any())
    <div class="alert alert-danger" style="font-size: 130%;">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mt-4 mb-3">


    @if(session('hiba'))
        <div class="alert alert-danger" style="font-size: 130%; text-align: center;">{{ session('hiba') }}</div>
    @endif

    @if(session('siker'))
        <div class="alert alert-success" style="font-size: 130%; text-align: center;">{{ session('siker') }}</div>
    @endif

    @php
        $kosar = session('kosar', []);
    @endphp

    <h2 style="text-align: center;">Kosár</h2>

    @if(!empty($kosar))
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Termék</th>
                    <th>Mennyiség</th>
                    <th>DB</th>
                    <th>Egységár (Ft)</th>
                    <th>Bruttó ár (Ft)</th>
                    <th>Művelet</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kosar as $termek)
                    @php
                        $brutto = $termek->netto_egyseg_ar * (1 + $termek->afa_kulcs / 100);
                        $brutto *= 1 - (($termek->kedvezmeny_szazalek ?? 0) / 100);
                        $brutto *= $termek->term_db_szam;
                    @endphp
                    <tr>
                        <td>{{ $termek->termek_nev }}</td>
                        <td>{{ $termek->term_db_szam }} {{ $termek->mennyisegi_egyseg }}</td>
                        <td>{{ $termek->term_db_szam }}</td>
                        <td>{{ $termek->netto_egyseg_ar }}</td>
                        <td>{{ round($brutto) }}</td>
                        <td>
                            <form action="/kosar/torles/{{ urlencode($termek->termek_nev) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Törlés
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @php
            $vegosszeg = 0;
            foreach ($kosar as $termek) {
                $brutto = $termek->netto_egyseg_ar * (1 + $termek->afa_kulcs / 100);
                $brutto *= 1 - (($termek->kedvezmeny_szazalek ?? 0) / 100);
                $brutto *= $termek->term_db_szam;
                $vegosszeg += (int) round($brutto);
            }
        @endphp

        <div class="mt-3">
            <h4>Végösszeg: {{ $vegosszeg }} Ft</h4>
        </div>


        <form method="POST" action="/vasarlas">
            @csrf

            @if(!auth()->check())
        <div class="row mt-3">
            <div class="col-md-6 mb-3">
                <label class="form-label">Név</label>
                <input type="text" name="nev" class="form-control" value="{{ old('nev') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Irányítószám</label>
                <input type="text" name="iranyitoszam" class="form-control" value="{{ old('iranyitoszam') }}" required>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Város</label>
                <input type="text" name="varos" class="form-control" value="{{ old('varos') }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Utca</label>
                <input type="text" name="utca" class="form-control" value="{{ old('utca') }}" required>
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label">Házszám</label>
                <input type="text" name="hazszam" class="form-control" value="{{ old('hazszam') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Emelet / ajtó</label>
                <input type="text" name="emelet_ajto" class="form-control" value="{{ old('emelet_ajto') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Telefonszám</label>
                <input type="text" name="tel_szam" class="form-control" value="{{ old('tel_szam') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Megjegyzés</label>
                <input type="text" name="megjegyzes" class="form-control" value="{{ old('megjegyzes') }}">
            </div>
        </div>
    @endif

            <div class="mt-3 mb-4">
                <label class="form-label">Fizetési mód</label>
                <select name="fiz_mod" class="form-select" required>
                    <option value="bankkartya">Bankkártya</option>
                    <option value="kezpenz">Utánvét / készpénz</option>
                </select>
            </div>

            <button class="btn btn-success mt-3 w-100">Megvásárlás</button>
        </form>
    @else
        <p class="mt-3">A kosár üres</p>
    @endif
</div>

@endsection
