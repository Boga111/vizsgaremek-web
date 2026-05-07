@extends('Layouts.app')
@section('content')

<div class="container mt-4">

    <h2 class="mb-4 text-center">Rendelések kezelése (Admin)</h2>

    @if(session('siker'))
        <div class="alert alert-success style="font-size: 130%;"">{{ session('siker') }}</div>
    @endif

    @if(session('hiba'))
        <div class="alert alert-danger style="font-size: 130%;"">{{ session('hiba') }}</div>
    @endif

    <div class="row g-4 mb-3">

        @foreach($rendelesek as $rendeles)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 product-card">
                    <div class="card-body mb-2 mt-2">

                        <h5 class="mt-3">Rendelés #{{ $rendeles->rendeles_id }}</h5>

                        <p><strong>Email:</strong> {{ $rendeles->email }}</p>
                        <p><strong>Típus:</strong> {{ $rendeles->rendeles_tipus }}</p>
                        <p><strong>Fizetés:</strong> {{ $rendeles->fiz_mod }}</p>
                        <p><strong>Állapot:</strong> {{ $rendeles->allapot }}</p>
                        <p><strong>Végösszeg:</strong> {{ $rendeles->vegosszeg }} Ft</p>
                        <p><strong>Dátum:</strong> {{ date('Y. m. d. H:i', strtotime($rendeles->rendeles_ido)) }}</p>

                        @if($rendeles->allapot !== 'Kiszallitva')
                        <form method="POST" action="/admin/rendeles/{{ $rendeles->rendeles_id }}/allapot">
                        @csrf
                            <select name="allapot" class="form-control mb-2">
                            <option value="készítés alatt"
                                {{ $rendeles->allapot === 'készítés alatt' ? 'selected' : '' }}>
                                Készítés alatt
                            </option>
                            <option value="kész" {{ $rendeles->allapot === 'kész' ? 'selected' : '' }}>
                                Kész
                            </option>
                            <option value="uton" {{ $rendeles->allapot === 'uton' ? 'selected' : '' }}>
                                Úton
                            </option>
                            <option value="kiszallitva" {{ $rendeles->allapot === 'kiszallitva' ? 'selected' : '' }}>
                                Kiszállítva
                            </option>
                            </select>
                            <button class="btn btn-warning w-100">
                                Állapot frissítése
                            </button>
                        </form>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach

    </div>

</div>

@endsection
