@extends('Layouts.app')

@section('content')
<div class="container my-5">

    <div id="szamla" class="mx-auto p-5 bg-white" style="max-width: 900px; border: 1px solid #ccc;">

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="fw-bold mb-1">SZÁMLA</h2>
                <p class="mb-1"><strong>Sorszám:</strong> {{ $szamla->szla_teljsorszam }}</p>
                <p class="mb-1"><strong>Kelte:</strong> {{ date('Y. m. d. H:i', strtotime($szamla->kibocsatas_datuma)) }}</p>
                <p class="mb-1"><strong>Teljesítés:</strong> {{ date('Y. m. d.', strtotime($szamla->teljesites_datuma)) }}</p>
                <p class="mb-0"><strong>Fizetési mód:</strong> {{ $szamla->fiz_mod === 'kartya' ? 'Kártya' : 'Készpénz' }}</p>
            </div>

            <div class="text-end">
                <h5 class="fw-bold mb-2">Turbo Tányér</h5>
                <p class="mb-1">Cím: Budapest, Üteg utca 15., 1139</p>
                <p class="mb-1">Email: turbotanyer@gmail.com</p>
                <p class="mb-0">Adószám: 12345678-9-12</p>
            </div>
        </div>

        <hr>

        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="fw-bold">Eladó</h6>
                <p class="mb-1">Turbo Tányér</p>
                <p class="mb-1">Budapest, Üteg utca 15., 1139</p>
                <p class="mb-1">turbotanyer@gmail.com</p>
                <p class="mb-0">Adószám: 12345678-9-12</p>
            </div>

            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <h6 class="fw-bold">Vevő</h6>
                <p class="mb-1">{{ auth()->user()->nev }}</p>
                <p class="mb-1">{{ auth()->user()->email }}</p>
                <p class="mb-1">{{ $cim->cim ?? 'Nincs megadva cím' }}</p>
                @if($cim && $cim->megjegyzes)
                    <p class="mb-0">Megjegyzés: {{ $cim->megjegyzes }}</p>
                @endif
            </div>
        </div>

        <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Termék megnevezése</th>
                        <th>Mennyiség</th>
                        <th>Nettó egységár</th>
                        <th>ÁFA %</th>
                        <th>Nettó érték</th>
                        <th>Bruttó érték</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tetelLista as $tetel)
                        @php
                            $nettoErtek = round($tetel->szamitott_netto);
                            $bruttoErtek = round($tetel->szamitott_brutto);
                        @endphp
                        <tr class="text-center">
                            <td class="text-start">{{ $tetel->termek_nev }}</td>
                            <td>{{ $tetel->term_db_szam }} {{ $tetel->mennyisegi_egyseg ?? 'db' }}</td>
                            <td>{{ number_format($tetel->netto_egyseg_ar, 0, ',', ' ') }} Ft</td>
                            <td>{{ $tetel->afa_kulcs }}%</td>
                            <td>{{ number_format($nettoErtek, 0, ',', ' ') }} Ft</td>
                            <td>{{ number_format($bruttoErtek, 0, ',', ' ') }} Ft</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end">
            <div style="min-width: 320px;">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Végösszeg áfa nélkül</strong></td>
                        <td class="text-end">{{ number_format($nettoOsszesen, 0, ',', ' ') }} Ft</td>
                    </tr>
                    <tr>
                        <td><strong>Áfa értéke</strong></td>
                        <td class="text-end">{{ number_format($afaOsszesen, 0, ',', ' ') }} Ft</td>
                    </tr>
                    <tr>
                        <td><strong>Fizetendő végösszeg</strong></td>
                        <td class="text-end fw-bold fs-5">{{ number_format($bruttoOsszesen, 0, ',', ' ') }} Ft</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-5 pt-4 text-center" style="border-top: 1px solid #ddd;">
            <small>Köszönjük a rendelést!</small>
        </div>
    </div>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-success">
            Nyomtatás / Mentés PDF-be
        </button>

        <a href="/profil" class="btn btn-secondary ms-2">
            Vissza
        </a>
    </div>
</div>

@endsection
