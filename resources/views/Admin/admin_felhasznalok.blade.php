@extends('Layouts.app')
@section('content')

<div class="container mt-4">

    <h2 class="text-center mb-4">Felhasználók kezelése (Admin)</h2>

    @if(session('siker'))
        <div class="alert alert-success "style="font-size: 130%;">{{ session('siker') }}</div>
    @endif

    @if(session('hiba'))
        <div class="alert alert-danger "style="font-size: 130%;">{{ session('hiba') }}</div>
    @endif

    <div class="row g-4">

        @foreach($felhasznalok->where('email', auth()->user()->email) as $user)
            <div class="col-12">
                <div class="card h-100 product-card text-white">
                    <div class="card-body mb-2 mt-2 text-center">

                        <h4 class="text-danger">ADMIN FIÓK</h4>

                        <img src="{{ asset('img/' . ($user->profil_kep ?? 'default.png')) }}"
                            width="150"
                            height="150"
                            class="rounded-circle mb-3"
                            style="object-fit: cover;"
                            alt="Profilkép"
                        >

                        <h4>{{ $user->nev }}</h4>
                        <p>{{ $user->email }}</p>
                        <p><strong>Telefon:</strong> {{ $user->tel_szam }}</p>
                        <p><strong>Jogosultság:</strong> {{ $user->jogosultsag }}</p>

                        <form method="POST" action="/profilkep" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="profil_kep" class="form-control mb-2 @error('profil_kep') is-invalid @enderror">

                            @error('profil_kep')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            <button class="btn btn-light w-100 mb-2">Profilkép frissítés</button>
                        </form>

                        <a href="/newpass" class="btn btn-light w-100 mb-2">
                            Jelszó módosítás
                        </a>

                        <form method="POST" action="/logout">
                            @csrf
                            <button class="btn btn-dark w-100">Kijelentkezés</button>
                        </form>

                    </div>
                </div>
            </div>
        @endforeach

        @foreach($felhasznalok->where('email', '!=', auth()->user()->email) as $user)
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="card h-100 product-card text-white">
                    <div class="card-body mb-2 mt-2 text-center">

                        <img src="{{ asset('img/' . ($user->profil_kep ?? 'default.png')) }}"
                            width="100"
                            height="100"
                            class="rounded-circle mb-3"
                            style="object-fit: cover;"
                            alt="Profilkép"
                        >

                        <h5>{{ $user->nev }}</h5>
                        <p>{{ $user->email }}</p>
                        <p><strong>Telefon:</strong> {{ $user->tel_szam }}</p>
                        <p><strong>Jogosultság:</strong> {{ $user->jogosultsag }}</p>

                        <form method="POST" action="/admin/felhasznalo/{{ $user->email }}/role">
                            @csrf
                            <select name="jogosultsag" class="form-control mb-2">
                                <option value="felhasználó" {{ $user->jogosultsag === 'felhasználó' ? 'selected' : '' }}>felhasználó</option>
                                <option value="futár" {{ $user->jogosultsag === 'futár' ? 'selected' : '' }}>futár</option>
                                <option value="admin" {{ $user->jogosultsag === 'admin' ? 'selected' : '' }}>admin</option>
                            </select>
                            <button class="btn btn-warning w-100 mb-2">
                                Jogosultság módosítása
                            </button>
                        </form>

                        <form method="POST" action="/admin/felhasznalo/{{ $user->email }}/profilkep-reset">
                            @csrf
                            <button class="btn btn-secondary w-100 mb-2"
                                    onclick="return confirm('Biztosan visszaállítod a profilképet alapértelmezettre?')">
                                Profilkép visszaállítása
                            </button>
                        </form>

                        <form method="POST" action="/admin/felhasznalo/{{ $user->email }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-100" onclick="return confirm('Biztos törlöd?')">
                                Törlés
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
