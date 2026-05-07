@extends('Layouts.app')
@section('content')

<div class="container mt-4">
    <h1 class="text-center py-3">Futár profil</h1>

    @if(session('siker'))
        <div class="alert alert-success w-50 mx-auto text-center" style="font-size: 130%;">
            {{ session('siker') }}
        </div>
    @endif

    @if(session('hiba'))
        <div class="alert alert-danger w-50 mx-auto text-center" style="font-size: 130%;">
            {{ session('hiba') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3 mt-3">Szia {{ Auth::user()->nev }}!</h5>

                    <p><strong>E-mail:</strong><br>{{ Auth::user()->email }}</p>
                    <p><strong>Telefon:</strong><br>{{ Auth::user()->tel_szam }}</p>
                    <p><strong>Jogosultság:</strong><br>{{ Auth::user()->jogosultsag }}</p>

                    <div class="mb-3 text-center">
                        <img
                            src="{{ asset('img/' . (Auth::user()->profil_kep ?? 'default.png')) }}"
                            width="150"
                            height="150"
                            class="rounded-circle mb-2"
                            style="object-fit: cover;"
                            alt="Profilkép"
                        >

                        <form action="/profilkep" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="profil_kep" class="form-control mb-2 @error('profil_kep') is-invalid @enderror" required>

                            @error('profil_kep')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            <button type="submit" class="btn btn-secondary w-100">
                                Profilkép módosítása
                            </button>
                        </form>
                    </div>

                    <div class="mt-4">
                        <a class="btn btn-primary w-100 mb-2 rounded" href="/newpass">
                            Jelszó módosítás
                        </a>

                        <form action="/logout" method="POST">
                            @csrf
                            <button class="btn btn-danger w-100 rounded">
                                Kilépés
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h4 class="mb-3">Fuvar előzmények</h4>

            <div style="max-height: 500px; overflow-y: auto; overflow-x: hidden; padding-right: 10px;">
                @forelse($fuvarok as $r)
                    <div class="card p-3 mb-3">
                        <h5>#{{ $r->rendeles_id }} • {{ $r->vegosszeg }} Ft • {{ $r->fiz_mod }}</h5>
                        <p class="mb-1"><b>Állapot:</b> {{ $r->allapot }}</p>
                        <p class="mb-1"><b>Idő:</b> {{ date('Y. m. d.', strtotime($r->rendeles_ido)) }}</p>
                        <p class="mb-1"><b>Cím:</b> {{ $r->cim ?? '-' }}</p>
                        <p class="mb-0"><b>Megjegyzés:</b> {{ $r->megjegyzes ?? '-' }}</p>

                        @if($r->cim)
                            <div class="ratio ratio-16x9 mt-3">
                                <iframe
                                    src="https://www.google.com/maps?q={{ urlencode($r->cim) }}&output=embed"
                                    loading="lazy">
                                </iframe>
                            </div>
                        @endif
                    </div>
                @empty
                    <p>Még nincs fuvar előzményed.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
