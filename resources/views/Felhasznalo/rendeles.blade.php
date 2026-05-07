@extends('Layouts.app')
@section('content')

<div class="container mt-4 mb-4">
    <h2 class="mb-4" style="text-align: center;">Rendelés</h2>

    <div class="input-group mb-3 align-items-center">
        <span class="mr-5">Keresés:</span>
        <input type="text" id="kereso" class="form-control" placeholder="Pl.: Töltött káposzta">
            <div class="input-group-append">
                <button class="btn" id="keres-btn">Keresés</button>
            </div>
            <ul id="ajanlasok" class="list-group"></ul>
    </div>

    <div class="row g-4">
        @foreach($etelek as $etel)
            @php
                $slug = \Illuminate\Support\Str::slug($etel->termek_nev, '-');
                $kepNev = \Illuminate\Support\Str::slug($etel->termek_nev, '_') . '.jpg';
            @endphp

            <div class="col-12 col-sm-6 col-md-4 col-lg-3" id="termek-{{ $slug }}">
                <div class="card product-card h-100 text-center">

                    <div class="product-img d-flex align-items-center justify-content-center">
                        <img src="{{ asset('img_kaja/' . $kepNev) }}"
                             class="img-fluid"
                             style="max-height: 180px; object-fit: contain;"
                             alt="{{ $etel->termek_nev }}">
                    </div>

                    <div class="card-body">
                        <h5>{{ $etel->termek_nev }}</h5>
                        <p>{{ $etel->netto_egyseg_ar }} Ft</p>

                        <div class="mt-3">
                            <label class="form-label">Darab</label>
                            <input type="number"
                                   class="form-control termek-db"
                                   min="1"
                                   max="20"
                                   value="1">
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

        if (darab < 1) {
            alert('Minimum 1 db terméket adhatsz meg!');
            return;
        }

        if (darab > 20) {
            alert('Maximum 20 db rendelhető egy termékből!');
            return;
        }

        if (darab >= 10) {
            const biztos = confirm('Biztosan ' + darab + ' db-ot szeretnél ebből a termékből a kosárba tenni?');

            if (!biztos) {
                return;
            }
        }

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
