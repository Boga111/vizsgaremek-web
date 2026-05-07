<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Túrbótányér</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo2.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
</head>
<body class="d-flex flex-column min-vh-100">

<header class="hero">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/etterem1.jpg') }}" class="d-block w-100" alt="Étterem 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/etterem2.jpg') }}" class="d-block w-100" alt="Étterem 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/etterem3.jpg') }}" class="d-block w-100" alt="Étterem 3">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

        <div class="hero-text">
            <h1>Turbó Tányér</h1>
            <p>Itt az illat már az ajtóban megfog.</p>
        </div>
    </div>
</header>

<nav class="navbar navbar-expand-lg" style="background:#a60000;">
    <div class="container">
        <img class="logo" src="{{ asset('img/logo2.png') }}" alt="logo">

        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        Étlap
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item text-white" href="/etlap/Előétel">Előételek</a></li>
                        <li><a class="dropdown-item text-white" href="/etlap/Leves">Levesek</a></li>
                        <li><a class="dropdown-item text-white" href="/etlap/Főétel">Főételek</a></li>
                        <li><a class="dropdown-item text-white" href="/etlap/Desszert">Desszertek</a></li>
                        <li><a class="dropdown-item text-white" href="/etlap/Ital">Italok</a></li>
                        <li><a class="dropdown-item text-white" href="/etlap/Köret">Köret</a></li>
                        <li><a class="dropdown-item text-white" href="/etlap/Magyar különlegesség">Magyaros különlegességek</a></li>
                        <li><a class="dropdown-item text-white" href="/etlap/Savanyúság">Savanyúság</a></li>
                        <li><a class="dropdown-item text-white" href="/etlap/Szeszes ital">Szeszes italok</a></li>
                    </ul>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/login">Bejelentkezés</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/reg">Regisztráció</a>
                    </li>
                @endguest

                @auth
                    @php
                        $jog = auth()->user()->jogosultsag;
                    @endphp

                    @if($jog === 'admin')
                        @php
                            $fuggobenLevoJelentkezok = \App\Models\User::where('futar_jelentkezes', 1)
                                ->where('futar_elfogadva', 0)
                                ->get();
                        @endphp

                        <li class="nav-item"><a class="nav-link text-white" href="/admin">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/admin/etelek">Ételek</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/admin/rendelesek">Rendelések</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/admin/foglalas">Asztalfoglalások</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/admin/felhasznalok">Felhasználók</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/admin/alkalmi-felhasznalok">PIN</a></li>

                        <li class="nav-item dropdown">
                            <a class="nav-link text-white position-relative" href="#" id="futarJelentkezesDropdown" role="button" data-bs-toggle="dropdown">
                                🔔
                                @if($fuggobenLevoJelentkezok->count() > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $fuggobenLevoJelentkezok->count() }}
                                    </span>
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end p-2" style="min-width: 380px; max-height: 500px; overflow-y: auto;">
                                <li class="dropdown-header fw-bold text-white">Futár jelentkezések</li>

                                @forelse($fuggobenLevoJelentkezok as $user)
                                    <li class="border-bottom pb-2 mb-2">
                                        <div>
                                            <strong>{{ $user->nev }}</strong><br>
                                            <small>{{ $user->email }}</small><br>
                                            <small>{{ $user->tel_szam }}</small>
                                        </div>

                                        <div class="d-flex gap-2 mt-2">
                                            <form action="/admin/futar-elfogadas/{{ $user->email }}" method="post">
                                                @csrf
                                                <button class="btn btn-success btn-sm">Elfogadás</button>
                                            </form>

                                            <form action="/admin/futar-elutasitas/{{ $user->email }}" method="post">
                                                @csrf
                                                <button class="btn btn-danger btn-sm">Elutasítás</button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="dropdown-item text-light">Nincs új futár jelentkezés.</li>
                                @endforelse
                            </ul>
                        </li>

                    @elseif($jog === 'futár')
                        <li class="nav-item"><a class="nav-link text-white" href="/futar">Futár panel</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/futar/cimek">Elvállalható címek</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/futar/sajat">Saját fuvarok</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/futar/profil">Profil</a></li>

                    @else
                        <li class="nav-item"><a class="nav-link text-white" href="/ajanlat">Napi ajánlat</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/kapcsolat">Kapcsolat</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/foglalas">Asztalfoglalás</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/rendeles">Rendelés</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/kosar">Kosár</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/profil">Profil</a></li>
                    @endif
                @endauth

            </ul>
        </div>
    </div>
</nav>

<main class="flex-fill">
    @yield('content')
</main>

<footer class="footer-box">
    <div class="footer-grid">
        <div>
            <h4>Elérhetőségeink</h4>
            <p>Tel.: 06 20 123 4567</p>
            <p>Email: turbotanyer@gmail.com</p>
        </div>

        <div>
            <h4>Elhelyezkedésünk</h4>
            <p>Budapest, Üteg u. 15, 1139</p>
        </div>

        <div>
            <h4>Nyitvatartás</h4>
            <p>Hétfő – Péntek: 10:00 - 20:00</p>
            <p>Szombat – Vasárnap: 10:00 - 22:00</p>
        </div>
    </div>

    <p class="footer-copy">Minden jog fenntartva - © 2026 Budapest</p>
</footer>
@stack('scripts')
</body>
</html>
