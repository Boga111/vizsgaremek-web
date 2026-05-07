@extends('Layouts.app')
@section('content')

<div class="container mt-5">
    <h2 style="text-align: center;">Foglalások (Admin)</h2>

    @if(session('siker'))
        <div class="alert alert-success" style="font-size: 130%; text-align: center;">{{ session('siker') }}</div>
    @endif

    @if(session('hiba'))
        <div class="alert alert-danger" style="font-size: 130%; text-align: center;">{{ session('hiba') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Név</th>
                <th>Email</th>
                <th>Asztal</th>
                <th>Időpont</th>
                <th>Fő</th>
                <th>Állapot</th>
                <th>Művelet</th>
            </tr>
        </thead>
        <tbody>
            @foreach($foglalasok as $f)
                <tr>
                    <td>{{ $f->nev }}</td>
                    <td>{{ $f->email }}</td>
                    <td>{{ $f->asztalszam }}</td>
                    <td>{{ $f->idopont }}</td>
                    <td>{{ $f->fo_db }}</td>
                    <td>{{ $f->allapot }}</td>
                    <td>
                        <form method="POST" action="/admin/foglalas/{{ $f->foglalas_id }}/allapot" class="d-flex gap-2">
                            @csrf

                            <select name="allapot" class="form-select form-select-sm">
                                <option value="folyamatban" {{ $f->allapot == 'folyamatban' ? 'selected' : '' }}>folyamatban</option>
                                <option value="megjött" {{ $f->allapot == 'megjött' ? 'selected' : '' }}>megjött</option>
                                <option value="törölve" {{ $f->allapot == 'törölve' ? 'selected' : '' }}>törölve</option>
                            </select>

                            <button type="submit" class="btn btn-primary btn-sm">Mentés</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
