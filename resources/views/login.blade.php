@extends('Layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        @if(session('siker'))
            <div class="alert alert-success mt-3" style="font-size: 130%;">
                {{ session('siker') }}
            </div>
        @endif
        @if(session('kudarc'))
            <div class="alert alert-danger mt-3" style="font-size: 130%;">
                {{ session('kudarc') }}
            </div>
        @endif

        <h1 class="text-center py-3">Belépés</h1>

        <div class="card w-50 mx-auto mb-3">
            <form class="card-body" action="/login" method="post">
                @csrf

                <label class="form-label mt-2" for="email">E-mail cím: </label>
                <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{old('email')}}">
                @error('email')
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

                <button class="btn btn-primary mt-4 w-100" type="submit">Belépés</button>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/newpass.js') }}"></script>
@endsection
