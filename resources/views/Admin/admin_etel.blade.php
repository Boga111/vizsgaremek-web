@extends('Layouts.app')
@section('content')

<div class="container my-5">

    <h1 class="text-center fw-bold">Ételek kezelése (Admin)</h1>
    <p class="text-center mb-5">Itt tudod törölni és hozzáadni az ételeket.</p>

    <form method="GET" action="/admin/etelek">
        <div class="input-group mb-4 align-items-center">
            <span class="me-3">Keresés:</span>
            <input type="text" name="kereses" class="form-control"
                   placeholder="Pl.: Töltött káposzta"
                   value="{{ $kereses ?? '' }}">
            <button class="btn btn-warning">Keresés</button>
        </div>
    </form>

    @if(session('siker'))
        <div class="alert alert-success text-center" style="font-size: 130%;">
            {{ session('siker') }}
        </div>
    @endif

    @if(session('hiba'))
        <div class="alert alert-danger text-center" style="font-size: 130%;">
            {{ session('hiba') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $hiba)
                    <li>{{ $hiba }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <hr class="my-4">

    <h3 class="text-center mb-4">Új étel hozzáadása</h3>

    <form method="POST" action="/admin/etel" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">

            <div class="col-md-8">
                <label class="form-label">Név</label>
                <input type="text" name="termek_nev" class="form-control" value="{{ old('termek_nev') }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Típus</label>
                <select name="tipus" class="form-select" required>
                    <option value="" disabled {{ old('tipus') ? '' : 'selected' }}>Válassz típust...</option>
                    <option value="Desszert" {{ old('tipus') == 'Desszert' ? 'selected' : '' }}>Desszert</option>
                    <option value="Előétel" {{ old('tipus') == 'Előétel' ? 'selected' : '' }}>Előétel</option>
                    <option value="Főétel" {{ old('tipus') == 'Főétel' ? 'selected' : '' }}>Főétel</option>
                    <option value="Ital" {{ old('tipus') == 'Ital' ? 'selected' : '' }}>Ital</option>
                    <option value="Köret" {{ old('tipus') == 'Köret' ? 'selected' : '' }}>Köret</option>
                    <option value="Leves" {{ old('tipus') == 'Leves' ? 'selected' : '' }}>Leves</option>
                    <option value="Magyar különlegesség" {{ old('tipus') == 'Magyar különlegesség' ? 'selected' : '' }}>Magyar különlegesség</option>
                    <option value="Savanyúság" {{ old('tipus') == 'Savanyúság' ? 'selected' : '' }}>Savanyúság</option>
                    <option value="Szeszes ital" {{ old('tipus') == 'Szeszes ital' ? 'selected' : '' }}>Szeszes ital</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    Mennyiségi egység
                    <span class="ms-2 text-primary"
                          data-bs-toggle="tooltip"
                          data-bs-placement="right"
                          title="Kajáknál: pl. 1 adag, italoknál: pl. 0.5 l vagy 33 cl">
                        ⓘ
                    </span>
                </label>
                <input type="text" name="mennyisegi_egyseg" class="form-control" value="{{ old('mennyisegi_egyseg') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nettó egységár (Ft)</label>
                <input type="number" name="netto_egyseg_ar" class="form-control" min="0" step="1" value="{{ old('netto_egyseg_ar') }}" required>
                <small class="text-muted">Csak egész szám adható meg, pl. 2500</small>
            </div>

            <div class="col-md-6">
                <label class="form-label">ÁFA kulcs (%)</label>
                <input type="number" name="afa_kulcs" class="form-control" min="0" max="100" value="{{ old('afa_kulcs', 27) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Akció (%)</label>
                <input type="number" name="akcio_szazalek" class="form-control" min="0" max="100" value="{{ old('akcio_szazalek', 0) }}">
            </div>

            <div class="col-md-12">
                <label class="form-label">Kép feltöltése</label>
                <input type="file" name="kep" class="form-control" accept=".jpg,.jpeg,.png,image/*" required>
            </div>

            <div class="alert alert-danger mt-2" style="font-size: 130%; text-align: center;">
                <small id="length" class="text-danger">Ékezet nélkül egybe, szóköz elválasztás helyett meg _ legyen pl: toltott_kaposzta</small><br>
            </div>

            <div class="col-md-12">
                <label class="form-label">Leírás</label>
                <textarea name="leiras" class="form-control" rows="3" required>{{ old('leiras') }}</textarea>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success w-100 mt-2">
                    Étel hozzáadása
                </button>
            </div>

        </div>
    </form>

    <hr class="my-5">

    <div class="row g-4">
        @forelse($etelek as $etel)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card text-center h-100 product-card">

                    <div class="product-img mt-3 mb-3 d-flex align-items-center justify-content-center">
                        @php
                            if ($etel->kep) {
                                $kepNev = $etel->kep;
                            } else {
                                $kepNev = \Illuminate\Support\Str::slug($etel->termek_nev, '_') . '.jpg';
                            }
                        @endphp

                        <img src="{{ asset('img_kaja/' . $kepNev) }}"
                            class="img-fluid"
                            alt="{{ $etel->termek_nev }}">
                    </div>

                    <div class="card-body mb-2 mt-2 text-white">
                        <h5>{{ $etel->termek_nev }}</h5>
                        <p>{{ $etel->leiras }}</p>

                        @php
                            $brutto = $etel->netto_egyseg_ar * (1 + $etel->afa_kulcs / 100);
                            $brutto *= 1 - (($etel->akcio_szazalek ?? 0) / 100);
                        @endphp

                        <p class="fw-bold">{{ round($brutto) }} Ft</p>

                        <form method="POST" action="/admin/etel/{{ urlencode($etel->termek_nev) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 mt-2" onclick="return confirm('Biztos törlöd?')">
                                Törlés
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-secondary text-center">
                    Nincs találat
                </div>
            </div>
        @endforelse
    </div>

</div>

@endsection