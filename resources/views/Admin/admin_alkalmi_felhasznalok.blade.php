@extends('Layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4" style="text-align: center;">PIN kezelés</h2>

    @if(session('siker'))
        <div class="alert alert-success" style="font-size: 130%; text-align: center;">{{ session('siker') }}</div>
    @endif

    @if(session('hiba'))
        <div class="alert alert-danger" style="font-size: 130%; text-align: center;">{{ session('hiba') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="font-size: 130%; text-align: center;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header text-white" style="font-size: 120%;">Új PIN hozzáadása</div>
        <div class="card-body">
            <form action="/admin/alkalmi-felhasznalo" method="post">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Szerepkör</label>
                        <select name="felhasznalok" class="form-select" required>
                            <option value="">Válassz...</option>
                            <option value="pincer">Pincér</option>
                            <option value="konyha">Konyha</option>
                            <option value="helyfoglalas">Helyfoglalás</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">PIN</label>
                        <input type="text" name="pin" class="form-control" placeholder="4 számjegy" maxlength="4" inputmode="numeric" pattern="[0-9]{4}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                    </div>
                </div>

                <button class="btn btn-success mt-3">Hozzáadás</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header text-white" style="font-size: 120%;">Meglévő PIN-ek</div>
        <div class="card-body">
            @if($alkalmiFelhasznalok->count() > 0)
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Szerepkör</th>
                            <th>PIN</th>
                            <th>Művelet</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alkalmiFelhasznalok as $felhasznalo)
                            <tr>
                                <td>{{ ucfirst($felhasznalo->felhasznalok) }}</td>
                                <td><strong>{{ $felhasznalo->pin }}</strong></td>
                                <td>
                                    <form action="/admin/alkalmi-felhasznalo/{{ $felhasznalo->felhaszn_id }}/modositas" method="post" class="d-flex gap-2">
                                        @csrf
                                        <input type="text" name="pin" class="form-control" value="{{ $felhasznalo->pin }}" maxlength="4" inputmode="numeric" pattern="[0-9]{4}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                        <button class="btn btn-primary">Módosítás</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="mb-0">Még nincs PIN felvéve.</p>
            @endif
        </div>
    </div>
</div>
@endsection
