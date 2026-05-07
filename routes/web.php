<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Focontroller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FutarController;

# Főoldal
Route::get('/', [Focontroller::class, 'Welcome']);
Route::get('/kapcsolat', function () {
    return view('Felhasznalo.kapcsolat');
});

# Étlap
Route::get('/etlap/{tipus}', [Focontroller::class, 'Kategoriak']);
Route::get('/autocomplete', [Focontroller::class, 'Autocomplete']);
Route::get('/kereses', [Focontroller::class, 'Kereses']);
Route::get('/ajanlat', [Focontroller::class, 'Ajanlat']);

# Belépés / regisztráció
Route::get('/login', [UserController::class, 'Login']);
Route::post('/login', [UserController::class, 'LoginButton']);
Route::get('/reg', [UserController::class, 'Reg']);
Route::post('/reg', [UserController::class, 'RegButton']);

# Vásárlás
Route::get('/rendeles', [Focontroller::class, 'Rendeles']);
Route::get('/kosar', [Focontroller::class, 'Kosar']);
Route::post('/kosarba-ajax', [Focontroller::class, 'KosarbaAjax']);
Route::post('/vasarlas', [Focontroller::class, 'Vasarlas']);
Route::get('/kosarba/{termek_nev}', [Focontroller::class, 'Kosarba']);
Route::post('/kosar/torles/{termek_nev}', [Focontroller::class, 'KosarTorles']);

# Bejelentkezett felhasználóknak
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [Focontroller::class, 'Profil']);
    Route::post('/profilkep', [UserController::class, 'Profilkep']);
    Route::get('/newpass', [UserController::class, 'Newpass']);
    Route::post('/newpass', [UserController::class, 'NewpassButton']);
    Route::post('/logout', [UserController::class, 'Logout']);
    Route::post('/cimmodositas', [Focontroller::class, 'CimModositas']);
    Route::get('/rendelesi-elozmenyek', [Focontroller::class, 'RendelesiElozmenyek']);
    Route::get('/szamla/{rendeles_id}', [Focontroller::class, 'SzamlaMegtekintes']);
    Route::match(['get', 'post'], '/foglalas', [Focontroller::class, 'Foglalas']);
});

# Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'Dashboard']);
    Route::get('/admin/etelek', [AdminController::class, 'Etelek']);
    Route::post('/admin/etel', [AdminController::class, 'Hozzaadas']);
    Route::delete('/admin/etel/{nev}', [AdminController::class, 'EtelTorles']);
    Route::get('/admin/rendelesek', [AdminController::class, 'Rendelesek']);
    Route::post('/admin/rendeles/{id}/allapot', [AdminController::class, 'AllapotValtas']);
    Route::get('/admin/felhasznalok', [AdminController::class, 'Felhasznalok']);
    Route::post('/admin/felhasznalo/{email}/role', [AdminController::class, 'RoleValtas']);
    Route::delete('/admin/felhasznalo/{email}', [AdminController::class, 'FelhasznaloTorles']);
    Route::post('/admin/felhasznalo/{email}/profilkep-reset', [AdminController::class, 'ProfilkepReset']);
    Route::get('/admin/foglalas', [AdminController::class, 'Foglalas']);
    Route::post('/admin/foglalas/{id}/allapot', [AdminController::class, 'FoglalasAllapotValtozas']);
    Route::get('/admin/futarjelentkezesek', [AdminController::class, 'FutarJelentkezesek']);
    Route::post('/admin/futar-elfogadas/{email}', [AdminController::class, 'FutarElfogadas']);
    Route::post('/admin/futar-elutasitas/{email}', [AdminController::class, 'FutarElutasitas']);
    Route::get('/admin/alkalmi-felhasznalok', [AdminController::class, 'AlkalmiFelhasznalok']);
    Route::post('/admin/alkalmi-felhasznalo', [AdminController::class, 'AlkalmiFelhasznaloHozzaadas']);
    Route::post('/admin/alkalmi-felhasznalo/{id}/modositas', [AdminController::class, 'AlkalmiFelhasznaloModositas']);
});

# Futár
Route::middleware(['auth', 'futar'])->group(function () {
    Route::get('/futar', [FutarController::class, 'Attekintes']);
    Route::get('/futar/cimek', [FutarController::class, 'Cimek']);
    Route::post('/futar/rendeles/{rendeles_id}/elvallal', [FutarController::class, 'Elvallal']);
    Route::get('/futar/sajat', [FutarController::class, 'Sajat']);
    Route::post('/futar/rendeles/{id}/allapot', [FutarController::class, 'Allapot']);
    Route::get('/futar/profil', [FutarController::class, 'Profil']);
});
