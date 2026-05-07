@extends('Layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center py-3">Profil információ</h1>

    @if(session('siker'))
        <div class="alert alert-success w-150 mx-auto" style="font-size: 130%; text-align: center;">
            {{ session('siker') }}
        </div>
    @endif

    @if(session('hiba'))
        <div class="alert alert-danger w-150 mx-auto" style="font-size: 130%; text-align: center;">
            {{ session('hiba') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3 mt-3">Szia {{ Auth::user()->nev }}!</h5>

                    <p>
                        <strong>E-mail cím:</strong><br>
                        {{ Auth::user()->email }}
                    </p>

                    <p>
                        <strong class="cim-fejlec">Szállítási cím:</strong><br>
                        <span class="cim-szoveg">
                            {{ $cim->cim ?? 'Nincs megadva cím' }}
                            <img
                                src="{{ asset('img/ceruza.png') }}"
                                id="cimSzerkesztesGomb"
                                class="ceruza-ikon"
                                alt="Cím módosítása"
                            >
                        </span>
                    </p>

                    @if($cim && $cim->megjegyzes)
                        <p>
                            <strong>Megjegyzés:</strong><br>
                            {{ $cim->megjegyzes }}
                        </p>
                    @endif

                    <div class="mb-3 text-center">
                        <img
                            src="{{ asset('img/' . (Auth::user()->profil_kep ?? 'default.png')) }}"
                            width="150"
                            height="150"
                            class="rounded-circle mb-3"
                            style="object-fit: cover;"
                            alt="Profilkép"
                        >

                        <form action="/profilkep" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input
                                type="file"
                                name="profil_kep"
                                class="form-control mb-2 @error('profil_kep') is-invalid @enderror"
                                required
                            >

                            @error('profil_kep')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            <button type="submit" class="btn btn-secondary w-100">
                                Profilkép módosítása
                            </button>
                        </form>
                    </div>

                    <div id="cimForm" style="display: {{ $errors->has('iranyitoszam') || $errors->has('varos') || $errors->has('utca') || $errors->has('hazszam') || $errors->has('emelet_ajto') || $errors->has('megjegyzes') ? 'block' : 'none' }};">
                        <form action="/cimmodositas" method="POST" class="mt-3">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label" for="iranyitoszam">Irányítószám:</label>
                                    <input type="text" name="iranyitoszam" id="iranyitoszam" class="form-control mb-2 @error('iranyitoszam') is-invalid @enderror" value="{{ old('iranyitoszam') }}" required>
                                    @error('iranyitoszam')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label" for="varos">Város:</label>
                                    <input type="text" name="varos" id="varos" class="form-control mb-2 @error('varos') is-invalid @enderror" value="{{ old('varos') }}" required>
                                    @error('varos')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label" for="utca">Utca:</label>
                                    <input type="text" name="utca" id="utca" class="form-control mb-2 @error('utca') is-invalid @enderror" value="{{ old('utca') }}" required>
                                    @error('utca')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="hazszam">Házszám:</label>
                                    <input type="text" name="hazszam" id="hazszam" class="form-control mb-2 @error('hazszam') is-invalid @enderror" value="{{ old('hazszam') }}" required>
                                    @error('hazszam')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <label class="form-label" for="emelet_ajto">Emelet / ajtó:</label>
                            <input type="text" name="emelet_ajto" id="emelet_ajto" class="form-control mb-2 @error('emelet_ajto') is-invalid @enderror" value="{{ old('emelet_ajto') }}">
                            @error('emelet_ajto')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <label class="form-label" for="megjegyzes">Megjegyzés:</label>
                            <input type="text" name="megjegyzes" id="megjegyzes" class="form-control mb-3 @error('megjegyzes') is-invalid @enderror" value="{{ old('megjegyzes', $cim->megjegyzes ?? '') }}">
                            @error('megjegyzes')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <button type="submit" class="btn btn-warning w-100">
                                Szállítási cím módosítása
                            </button>
                        </form>
                    </div>

                    <div class="mt-4">
                        <a class="btn btn-primary w-100 mb-2 rounded" href="/newpass">
                            Jelszó módosítás
                        </a>

                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100 rounded">
                                Kilépés
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h4 class="mb-3">Vásárlási előzmények</h4>

            <div style="max-height: 500px; overflow-y: auto; overflow-x: hidden; padding-right: 20px;">
                @forelse($etelek as $rendelesId => $rendelesTermekek)
                    <h5>
                        Rendelés #{{ $rendelesId }},
                        Végösszeg: {{ $rendelesTermekek->first()->vegosszeg }} Ft
                    </h5>
                    @php
                        $elsoTetel = $rendelesTermekek->first();
                    @endphp

                    @if($elsoTetel->szla_teljsorszam)
                        <a href="/szamla/{{ $rendelesId }}" class="btn btn-dark mb-3">
                            Számla megtekintése
                        </a>
                    @endif

                    <div class="row g-4 mb-4">
                        @foreach($rendelesTermekek as $etel)
                            <div class="col-12 col-sm-6">
                                <div class="card text-center h-100 product-card">
                                    <div class="product-img d-flex align-items-center justify-content-center">
                                        @php
                                            $kepNev = \Illuminate\Support\Str::slug($etel->termek_nev, '_') . '.jpg';
                                        @endphp

                                        <img
                                            src="{{ asset('img_kaja/' . $kepNev) }}"
                                            class="img-fluid"
                                            alt="{{ $etel->termek_nev }}"
                                        >
                                    </div>

                                    <div class="card-body mb-2">
                                        <h6>{{ $etel->termek_nev }}</h6>
                                        <p>{{ $etel->term_db_szam }} {{ $etel->mennyisegi_egyseg }}</p>
                                        <p class="fw-bold">{{ round($etel->brutto_osszeg ?? 0) }} Ft</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p>Nincs még vásárlási előzmény.</p>
                @endforelse
            </div>

            @if($vanTobbRendeles)
                <div class="text-center mt-3">
                    <a href="/rendelesi-elozmenyek" class="btn btn-outline-primary">
                        Összes rendelési előzmény megtekintése
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/modositas.js') }}"></script>
@endsection
