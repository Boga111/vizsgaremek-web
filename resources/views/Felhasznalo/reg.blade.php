@extends('Layouts.app')
@section('content')
<div class="col-md-12">
    <h1 class="text-center py-3">Regisztráció</h1>
    <div class="card w-50 mb-3 mx-auto">
        <form class="card-body" action="/reg" method="post">
            @csrf

            <label class="form-label mt-3" for="nev">Név: </label>
            <input class="form-control @error('nev') is-invalid @enderror" type="text" name="nev" id="nev" value="{{old('nev')}}">
            @error('nev')
                <p class="text-danger" style="font-size: 130%;">{{ $message }}</p>
            @enderror

            <label class="form-label mt-3" for="email">E-mail cím: </label>
            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{old('email')}}">
            @error('email')
                <p class="text-danger" style="font-size: 130%;">{{ $message }}</p>
            @enderror

            <label class="form-label mt-3" for="tel_szam">Telefonszám: </label>
            <input class="form-control @error('tel_szam') is-invalid @enderror" type="text" name="tel_szam" id="tel_szam" placeholder="+36301234567 vagy 06301234567" value="{{ old('tel_szam') }}">
            @error('tel_szam')
                <p class="text-danger" style="font-size: 130%;">{{ $message }}</p>
            @enderror

            <h5 class="mt-4">Szállítási cím</h5>

            <div class="row">
                <div class="col-md-4">
                    <label class="form-label mt-3" for="iranyitoszam">Irányítószám:</label>
                    <input type="text" name="iranyitoszam" id="iranyitoszam"
                        class="form-control @error('iranyitoszam') is-invalid @enderror"
                        value="{{ old('iranyitoszam') }}">
                    @error('iranyitoszam')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-md-8">
                    <label class="form-label mt-3" for="varos">Város:</label>
                    <input type="text" name="varos" id="varos"
                        class="form-control @error('varos') is-invalid @enderror"
                        value="{{ old('varos') }}">
                    @error('varos')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <label class="form-label mt-3" for="utca">Utca:</label>
                    <input type="text" name="utca" id="utca"
                        class="form-control @error('utca') is-invalid @enderror"
                        value="{{ old('utca') }}">
                    @error('utca')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label mt-3" for="hazszam">Házszám:</label>
                    <input type="text" name="hazszam" id="hazszam"
                        class="form-control @error('hazszam') is-invalid @enderror"
                        value="{{ old('hazszam') }}">
                    @error('hazszam')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <label class="form-label mt-3" for="emelet_ajto">Emelet / ajtó:</label>
            <input type="text" name="emelet_ajto" id="emelet_ajto"
                class="form-control @error('emelet_ajto') is-invalid @enderror"
                value="{{ old('emelet_ajto') }}">
            @error('emelet_ajto')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label class="form-label mt-3" for="megjegyzes">Cím megjegyzés:</label>
            <input type="text" name="megjegyzes" id="megjegyzes"
                class="form-control @error('megjegyzes') is-invalid @enderror"
                value="{{ old('megjegyzes') }}">
            @error('megjegyzes')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label class="form-label mt-3" for="password">Jelszó: </label>
            <div class="position-relative">
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    onkeyup="checkPasswordStrength()">

                <span onclick="togglePassword('password')"
                    style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;">
                    👁
                </span>
            </div>
            @error('password')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <div class="mt-2" style="font-size: 120%;">
                <div class="progress mb-2" style="height: 8px;">
                    <div id="strengthBar" class="progress-bar" style="width: 0%"></div>
                </div>
                <small id="length" class="text-danger">❌ Minimum 8 karakter</small><br>
                <small id="lower" class="text-danger">❌ Kisbetű</small><br>
                <small id="upper" class="text-danger">❌ Nagybetű</small><br>
                <small id="number" class="text-danger">❌ Szám</small><br>
                <small id="symbol" class="text-danger">❌ Speciális karakter (!@#$ stb)</small>
            </div>

            <label class="form-label mt-3" for="password_confirmation">Jelszó újra: </label>
            <div class="position-relative">
                <input class="form-control @error('password_confirmation') is-invalid @enderror"
                    type="password" name="password_confirmation" id="password_confirmation">

                <span onclick="togglePassword('password_confirmation')"
                    style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;">
                    👁
                </span>
            </div>
            @error('password_confirmation')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" name="futar_jelentkezes" id="futar_jelentkezes" value="1" {{ old('futar_jelentkezes') ? 'checked' : '' }}>
                <label class="form-check-label" for="futar_jelentkezes">
                    Futárként szeretnék regisztrálni
                </label>
            </div>

            <button class="btn btn-primary mt-4 w-100" type="submit">Regisztrálok</button>
        </form>
    </div>
</div>

<script src="{{ asset('assets/js/tel.js') }}"></script>
<script src="{{ asset('assets/js/newpass.js') }}"></script>
@endsection
