<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Etlap;
use App\Models\Kosar;
use App\Models\Rendeles;
use App\Models\Helyfoglalas;
use App\Models\Szallitasi_cim;
use App\Models\Alkalm_Felhasz;

class AdminController extends Controller
{
    public function Dashboard(){
        $rendelesekSzama = Rendeles::count();
        $felhasznalokSzama = User::count();
        $bevetel = Rendeles::sum('vegosszeg');

        $topEtelek = Kosar::selectRaw('termek_nev, SUM(term_db_szam) as osszes')
            ->groupBy('termek_nev')
            ->orderByDesc('osszes')
            ->limit(5)
            ->get();

        $napi = Rendeles::selectRaw('DATE(rendeles_ido) as nap, SUM(vegosszeg) as brutto')
            ->whereNotNull('vegosszeg')
            ->groupByRaw('DATE(rendeles_ido)')
            ->orderBy('nap')
            ->get();

        $napiLabels = $napi->pluck('nap')->map(function ($datum) {
            return date('Y-m-d', strtotime($datum));
        })->toArray();

        $napiBrutto = $napi->pluck('brutto')->map(function ($osszeg) {
            return (int) $osszeg;
        })->toArray();

        $napiNetto = $napi->pluck('brutto')->map(function ($osszeg) {
            return (int) round($osszeg / 1.27);
        })->toArray();

        return view('Admin.admin_dashboard', compact(
            'rendelesekSzama',
            'felhasznalokSzama',
            'bevetel',
            'topEtelek',
            'napiLabels',
            'napiBrutto',
            'napiNetto'
        ));
    }

    public function Etelek(Request $request){
        $kereses = $request->kereses;
        if ($kereses) {
            $etelek = Etlap::where('termek_nev', 'like', '%' . $kereses . '%')->get();
        } else {
            $etelek = Etlap::all();
        }
        return view('Admin.admin_etel', compact('etelek', 'kereses'));
    }

    public function Hozzaadas(Request $request){
        $request->validate([
            'termek_nev' => 'required|max:50|unique:etlap,termek_nev',
            'tipus' => 'required|max:20',
            'mennyisegi_egyseg' => 'required|max:20',
            'netto_egyseg_ar' => 'required|integer|min:0',
            'afa_kulcs' => 'required|integer|min:0|max:100',
            'akcio_szazalek' => 'nullable|integer|min:0|max:100',
            'leiras' => 'required|max:255',
            'kep' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $slug = Str::slug($request->termek_nev, '_');
        $kiterjesztes = $request->file('kep')->getClientOriginalExtension();
        $kepNev = $slug . '.' . $kiterjesztes;

        if (File::exists(public_path('img_kaja/' . $kepNev))) {
            $kepNev = $slug . '_' . time() . '.' . $kiterjesztes;
        }

        $request->file('kep')->move(public_path('img_kaja'), $kepNev);

        $etel = new Etlap();
        $etel->termek_nev = $request->termek_nev;
        $etel->tipus = $request->tipus;
        $etel->mennyisegi_egyseg = $request->mennyisegi_egyseg;
        $etel->netto_egyseg_ar = $request->netto_egyseg_ar;
        $etel->afa_kulcs = $request->afa_kulcs;
        $etel->akcio_szazalek = $request->akcio_szazalek ? $request->akcio_szazalek : 0;
        $etel->leiras = $request->leiras;
        $etel->kep = $kepNev;
        $etel->save();

        return back()->with('siker', 'Az étel sikeresen hozzáadva!');
    }

    public function EtelTorles($nev){
        $etel = Etlap::where('termek_nev', urldecode($nev))->first();

        if (!$etel) {
            return back()->with('hiba', 'Az étel nem létezik!');
        }

        if ($etel->kep) {
            $kepUtvonal = public_path('img_kaja/' . $etel->kep);

            if (File::exists($kepUtvonal)) {
                File::delete($kepUtvonal);
            }
        }

        $etel->delete();

        return back()->with('siker', 'Étel törölve!');
    }

    public function Rendelesek(){
        $rendelesek = Rendeles::orderByDesc('rendeles_id')->get();

        return view('Admin.admin_rendelesek', compact('rendelesek'));
    }

    public function AllapotValtas(Request $request, $id){
         $rendeles = Rendeles::find($id);
        if (!$rendeles) {
            return back()->with('hiba', 'Nincs ilyen rendelés!');
        }

        if ($rendeles->allapot === 'kész' && $request->allapot === 'készítés alatt') {
            return back()->with('hiba', 'Az elkészült terméket nem lehet visszaállítani!');
        }

        if ($rendeles->allapot === 'kiszallitva') {
            return back()->with('hiba', 'Ez a rendelés már lezárt!');
        }
        $request->validate([
            'allapot' => 'required|in:készítés alatt,kész,uton,kiszallitva'
        ]);
        $rendeles->allapot = $request->allapot;
        $rendeles->save();
        return back()->with('siker', 'Állapot frissítve');
    }

    public function Felhasznalok(){
        $felhasznalok = User::all();

        return view('Admin.admin_felhasznalok', compact('felhasznalok'));
    }

    public function ProfilkepReset($email){
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('hiba', 'Nincs ilyen felhasználó!');
        }

        if ($user->profil_kep && $user->profil_kep !== 'default.png') {
            $kepUtvonal = public_path('img/' . $user->profil_kep);

            if (File::exists($kepUtvonal)) {
                File::delete($kepUtvonal);
            }
        }

        $user->profil_kep = 'default.png';
        $user->save();

        return back()->with('siker', 'Profilkép alaphelyzetbe állítva');
    }

    public function RoleValtas(Request $request, $email){
        $request->validate([
            'jogosultsag' => 'required|in:admin,futár,felhasználó'
        ]);

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('hiba', 'Nincs ilyen felhasználó!');
        }

        $user->jogosultsag = $request->jogosultsag;
        $user->save();

        return back()->with('siker', 'Jogosultság módosítva');
    }

    public function FelhasznaloTorles($email){
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->with('hiba', 'Nincs ilyen felhasználó!');
        }
        $cimek = Szallitasi_cim::where('email', $email)->get();
        foreach ($cimek as $cim) {
            Rendeles::where('cim_id', $cim->cim_id)->update([
                'cim_id' => null
            ]);
        }
        Rendeles::where('futar_email', $email)->update([
            'futar_email' => null
        ]);
        Rendeles::where('email', $email)->update([
            'email' => null
        ]);
        Helyfoglalas::where('email', $email)->update([
            'email' => null
        ]);
        Szallitasi_cim::where('email', $email)->delete();
        $user->delete();
        return back()->with('siker', 'Felhasználó törölve!');
    }

    public function Foglalas(){
        $foglalasok = Helyfoglalas::orderBy('idopont')->get();

        return view('Admin.admin_foglalas', compact('foglalasok'));
    }

    public function FoglalasAllapotValtozas(Request $request, $foglalas_id){
        $foglalas = Helyfoglalas::findOrFail($foglalas_id);
        $foglalas->allapot = $request->allapot;
        $foglalas->save();

        return redirect('admin/foglalas')->with('siker', 'Sikeresen változott az állapot!');
    }

    public function FutarJelentkezesek(){
        $jelentkezok = User::where('futar_jelentkezes', 1)
            ->where('futar_elfogadva', 0)
            ->get();

        return view('Admin.admin_futarjelentkezesek', compact('jelentkezok'));
    }

    public function FutarElfogadas($email){
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('hiba', 'Nincs ilyen felhasználó!');
        }

        $user->futar_jelentkezes = 0;
        $user->futar_elfogadva = 1;
        $user->jogosultsag = 'futár';
        $user->save();

        return back()->with('siker', 'A futár jelentkezés elfogadva!');
    }

    public function FutarElutasitas($email){
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('hiba', 'Nincs ilyen felhasználó!');
        }

        $user->futar_jelentkezes = 0;
        $user->futar_elfogadva = 0;
        $user->jogosultsag = 'felhasználó';
        $user->save();

        return back()->with('siker', 'A futár jelentkezés elutasítva!');
    }

    public function AlkalmiFelhasznalok(){
        $alkalmiFelhasznalok = Alkalm_Felhasz::whereIn('felhasznalok', ['pincer', 'konyha', 'helyfoglalas'])
            ->orderBy('felhasznalok')
            ->get();

        return view('Admin.admin_alkalmi_felhasznalok', compact('alkalmiFelhasznalok'));
    }

    public function AlkalmiFelhasznaloHozzaadas(Request $request){
        $request->validate([
            'felhasznalok' => 'required|in:pincer,konyha,helyfoglalas',
            'pin' => ['required', 'regex:/^[0-9]{4}$/', 'unique:alkalm_felhasz,pin']
        ], [
            'felhasznalok.required' => 'A szerepkör megadása kötelező!',
            'felhasznalok.in' => 'Csak pincér vagy konyha vagy helyfoglalás választható!',
            'pin.required' => 'A PIN megadása kötelező!',
            'pin.regex' => 'A PIN pontosan 4 számjegy lehet!',
            'pin.unique' => 'Ez a PIN már használatban van!'
        ]);

        $letezik = Alkalm_Felhasz::where('felhasznalok', $request->felhasznalok)->first();

        if ($letezik) {
            return back()->with('hiba', 'Ehhez a szerepkörhöz már van PIN!');
        }

        Alkalm_Felhasz::create([
            'felhasznalok' => $request->felhasznalok,
            'pin' => $request->pin
        ]);

        return back()->with('siker', 'PIN sikeresen hozzáadva!');
    }

    public function AlkalmiFelhasznaloModositas(Request $request, $id){
        $alkalmi = Alkalm_Felhasz::find($id);

        if (!$alkalmi) {
            return back()->with('hiba', 'Nincs ilyen rekord!');
        }

        $request->validate([
            'pin' => ['required', 'regex:/^[0-9]{4}$/', 'unique:alkalm_felhasz,pin,' . $id . ',felhaszn_id']
        ], [
            'pin.required' => 'A PIN megadása kötelező!',
            'pin.regex' => 'A PIN pontosan 4 számjegy lehet!',
            'pin.unique' => 'Ez a PIN már használatban van!'
        ]);

        $alkalmi->pin = $request->pin;
        $alkalmi->save();

        return back()->with('siker', 'PIN sikeresen módosítva!');
    }

}
