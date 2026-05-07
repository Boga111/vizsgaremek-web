@extends('Layouts.app')
@section('content')

<div class="container mt-4">
    <h1 class="text-center py-3">Összes rendelési előzmény</h1>

    @forelse($rendelesek as $rendeles)
        <div class="mb-4">
            <h5>
                Rendelés #{{ $rendeles->rendeles_id }},
                Végösszeg: {{ $rendeles->vegosszeg }} Ft
            </h5>
            <p>
                Időpont: {{ date_format(date_create($rendeles->rendeles_ido), "Y. m. d. H:i") }}
            </p>

            @if(isset($szamlak[$rendeles->rendeles_id]))
                <a href="/szamla/{{ $rendeles->rendeles_id }}" class="btn btn-dark mb-3">
                    Számla megtekintése
                </a>
            @endif

            <div class="row g-4 mb-4">
                @foreach($termekek[$rendeles->rendeles_id] ?? [] as $etel)
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card text-center h-100 product-card">
                            <div class="product-img d-flex align-items-center justify-content-center">
                                @php $kepNev = Str::slug($etel->termek_nev, '_') . '.jpg'; @endphp
                                <img src="{{ asset('img_kaja/' . $kepNev) }}" class="img-fluid">
                            </div>
                            <div class="card-body mb-2">
                                <h6>{{ $etel->termek_nev }}</h6>
                                <p>{{ $etel->term_db_szam }} {{ $etel->mennyisegi_egyseg }}</p>
                                <p class="fw-bold">
                                    {{ round($etel->netto_egyseg_ar * (1 + $etel->afa_kulcs / 100) * (1 - (($etel->kedvezmeny_szazalek ?? 0) / 100)) * $etel->term_db_szam) }} Ft
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p>Nincs még rendelési előzmény.</p>
    @endforelse

    <div class="d-flex justify-content-center">
        {{ $rendelesek->links() }}
    </div>
</div>

@endsection
