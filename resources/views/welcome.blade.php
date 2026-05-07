@extends('Layouts.app')
@section('content')
<div class="container my-5">

    <h1 class="text-center fw-bold">Magyaros különlegességek</h1>
    <p class="text-center mb-5">Ahol a pörköltnek becsülete van.</p>

    <div class="input-group mb-3 align-items-center">
        <span class="mr-5">Keresés:</span>
        <input type="text" id="kereso" class="form-control" placeholder="Pl.: Töltött káposzta">
        <div class="input-group-append">
            <button class="btn" id="keres-btn">Keresés</button>
        </div>
        <ul id="ajanlasok" class="list-group"></ul>
    </div>

    <div class="row g-4 justify-content-center">
        @foreach($etelek as $etel)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card text-center h-100 product-card">

                    <div class="product-img d-flex align-items-center justify-content-center mt-3">
                        @php
                            $kepNev = Str::slug($etel->termek_nev, '_') . '.jpg';
                        @endphp
                        <img src="{{ asset('img_kaja/' . $kepNev) }}" class="img-fluid" alt="{{ $etel->termek_nev }}">
                    </div>

                    <div class="card-body mb-2 text-white">
                        <h5>{{ $etel->termek_nev }}</h5>
                        <p>{{ $etel->leiras }}</p>

                        @php
                            $brutto = $etel->netto_egyseg_ar * (1 + $etel->afa_kulcs / 100);
                            $brutto = $brutto * (1 - $etel->akcio_szazalek / 100);
                        @endphp

                        <p class="fw-bold">{{ round($brutto) }} Ft</p>

                        <div class="mt-3">
                            <label class="form-label">Darab</label>
                            <input type="number" class="form-control termek-db" min="1" value="1">
                        </div>
                    </div>

                    <div class="p-3 mb-2" style="background: #2f5d3a;">
                        <button
                            type="button"
                            class="btn w-100 kosar-gomb"
                            data-termek="{{ $etel->termek_nev }}">
                            Kosárba
                        </button>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="kosarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Termék a kosárba került</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Mit szeretnél?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Rendelek tovább
                </button>
                <a href="/kosar" class="btn btn-success">
                    Megveszem
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.kosar-gomb').forEach(gomb => {
    gomb.addEventListener('click', function () {
        const termekNev = this.dataset.termek;
        const kartya = this.closest('.card');
        const darab = parseInt(kartya.querySelector('.termek-db').value) || 1;

        fetch("/kosarba-ajax", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                termek_nev: termekNev,
                darab: darab
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.siker) {
                const modal = new bootstrap.Modal(document.getElementById('kosarModal'));
                modal.show();
            } else {
                alert(data.hiba ?? 'Hiba történt');
            }
        })
        .catch(() => {
            alert('Hiba történt a kosárba rakásnál');
        });
    });
});
</script>


<script src="{{ asset('assets/js/kereses.js') }}"></script>
@endsection
