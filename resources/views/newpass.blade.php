@extends('Layouts.app')
@section('content')
<div class="container my-5" style="max-width: 600px;">
    <h2 class="text-center mb-4">Jelszó megváltoztatása</h2>
    @if(session('siker'))
        <div class="alert alert-success" style="font-size: 130%;">
            {{ session('siker') }}
        </div>
    @endif

    @if(session('kudarc'))
        <div class="alert alert-danger" style="font-size: 130%;">
            {{ session('kudarc') }}
        </div>
    @endif

    <form action="{{ url('/newpass') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Régi jelszó</label>
            
            <div class="position-relative">
                <input type="password" name="oldpassword" id="oldpassword"
                    class="form-control @error('oldpassword') is-invalid @enderror">

                <span onclick="togglePassword('oldpassword')"
                    style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;">
                    👁
                </span>
            </div>

            @error('oldpassword')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Új jelszó</label>
            
            <div class="position-relative">
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    onkeyup="checkPasswordStrength()">

                <span onclick="togglePassword('password')"
                    style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;">
                    👁
                </span>
            </div>

            <div class="mt-2">
                <div class="progress mb-2" style="height: 8px;">
                    <div id="strengthBar" class="progress-bar" style="width: 0%"></div>
                </div>

                <small id="length" class="text-danger">❌ Minimum 8 karakter</small><br>
                <small id="lower" class="text-danger">❌ Kisbetű</small><br>
                <small id="upper" class="text-danger">❌ Nagybetű</small><br>
                <small id="number" class="text-danger">❌ Szám</small><br>
                <small id="symbol" class="text-danger">❌ Speciális karakter (!@#$ stb)</small>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Új jelszó megerősítése</label>
            
            <div class="position-relative">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror">

                <span onclick="togglePassword('password_confirmation')"
                    style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;">
                    👁
                </span>
            </div>
        </div>

        <button class="btn btn-danger w-100">Jelszó módosítása</button>
    </form>
</div>
@endsection

<script src="{{ asset('assets/js/newpass.js') }}"></script>