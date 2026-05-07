@extends('Layouts.app')
@section('content')
<div class="container my-5">

    <h1 class="text-center fw-bold">Mai ajánlat</h1>
    <p class="text-center mb-5">A mai nap háromfogásos ajánlata:</p>

    <div class="row g-4 justify-content-center">

        <div class="col-12 col-md-4">
            <div class="card text-center h-100 product-card">

                <h4 class="mt-3 text-white">Leves</h4>

                <div class="product-img mt-3 mb-3 d-flex align-items-center justify-content-center">
                    @if($napi_leves)
                        @php $kepLeves = \Illuminate\Support\Str::slug($napi_leves->termek_nev, '_') . '.jpg'; @endphp
                        <img src="{{ asset('img_kaja/' . $kepLeves) }}" class="img-fluid" alt="{{ $napi_leves->termek_nev }}">
                    @endif
                </div>

                <div class="card-body mb-3 text-white">
                    <h5>{{ $napi_leves->termek_nev ?? 'Nincs ajánlat' }}</h5>
                    <p>{{ $napi_leves->leiras ?? 'Ehhez a kategóriához most nincs elérhető étel.' }}</p>

                    @if($napi_leves)
                        @php
                            $brutto = $napi_leves->netto_egyseg_ar * (1 + $napi_leves->afa_kulcs / 100);
                            $brutto *= 1 - (($napi_leves->akcio_szazalek ?? 0) / 100);
                        @endphp
                        <p class="fw-bold">{{ round($brutto) }} Ft</p>

                        <div class="mt-3">
                            <label class="form-label">Darab</label>
                            <input type="number" class="form-control termek-db" min="1" value="1">
                        </div>
                    @endif
                </div>

                @if($napi_leves)
                    <div class="p-3 mb-2" style="background: #2f5d3a;">
                        <button type="button" class="btn w-100 kosar-gomb" data-termek="{{ $napi_leves->termek_nev }}">
                            Kosárba
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card text-center h-100 product-card">

                <h4 class="mt-3 text-white">Főétel</h4>

                <div class="product-img mt-3 mb-3 d-flex align-items-center justify-content-center">
                    @if($napi_foetel)
                        @php $kepFoetel = \Illuminate\Support\Str::slug($napi_foetel->termek_nev, '_') . '.jpg'; @endphp
                        <img src="{{ asset('img_kaja/' . $kepFoetel) }}" class="img-fluid" alt="{{ $napi_foetel->termek_nev }}">
                    @endif
                </div>

                <div class="card-body mb-3 text-white">
                    <h5>{{ $napi_foetel->termek_nev ?? 'Nincs ajánlat' }}</h5>
                    <p>{{ $napi_foetel->leiras ?? 'Ehhez a kategóriához most nincs elérhető étel.' }}</p>

                    @if($napi_foetel)
                        @php
                            $brutto = $napi_foetel->netto_egyseg_ar * (1 + $napi_foetel->afa_kulcs / 100);
                            $brutto *= 1 - (($napi_foetel->akcio_szazalek ?? 0) / 100);
                        @endphp
                        <p class="fw-bold">{{ round($brutto) }} Ft</p>

                        <div class="mt-3">
                            <label class="form-label">Darab</label>
                            <input type="number" class="form-control termek-db" min="1" value="1">
                        </div>
                    @endif
                </div>

                @if($napi_foetel)
                    <div class="p-3 mb-2" style="background: #2f5d3a;">
                        <button type="button" class="btn w-100 kosar-gomb" data-termek="{{ $napi_foetel->termek_nev }}">
                            Kosárba
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card text-center h-100 product-card">

                <h4 class="mt-3 text-white">Desszert</h4>

                <div class="product-img mt-3 mb-3 d-flex align-items-center justify-content-center">
                    @if($napi_desszert)
                        @php $kepDesszert = \Illuminate\Support\Str::slug($napi_desszert->termek_nev, '_') . '.jpg'; @endphp
                        <img src="{{ asset('img_kaja/' . $kepDesszert) }}" class="img-fluid" alt="{{ $napi_desszert->termek_nev }}">
                    @endif
                </div>

                <div class="card-body mb-3 text-white">
                    <h5>{{ $napi_desszert->termek_nev ?? 'Nincs ajánlat' }}</h5>
                    <p>{{ $napi_desszert->leiras ?? 'Ehhez a kategóriához most nincs elérhető étel.' }}</p>

                    @if($napi_desszert)
                        @php
                            $brutto = $napi_desszert->netto_egyseg_ar * (1 + $napi_desszert->afa_kulcs / 100);
                            $brutto *= 1 - (($napi_desszert->akcio_szazalek ?? 0) / 100);
                        @endphp
                        <p class="fw-bold">{{ round($brutto) }} Ft</p>

                        <div class="mt-3">
                            <label class="form-label">Darab</label>
                            <input type="number" class="form-control termek-db" min="1" value="1">
                        </div>
                    @endif
                </div>

                @if($napi_desszert)
                    <div class="p-3 mb-2" style="background: #2f5d3a;">
                        <button type="button" class="btn w-100 kosar-gomb" data-termek="{{ $napi_desszert->termek_nev }}">
                            Kosárba
                        </button>
                    </div>
                @endif
            </div>
        </div>

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

<script>
document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll('.product-card');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, {
        threshold: 0.2
    });

    cards.forEach(card => {
        observer.observe(card);
    });
});
</script>
@endsection
