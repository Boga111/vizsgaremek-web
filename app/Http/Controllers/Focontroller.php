<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Etlap;
use App\Models\Asztalok;
use App\Models\Helyfoglalas;
use App\Models\Rendeles;
use App\Models\Szamla;
use App\Models\Kosar;
use App\Models\Szallitasi_cim;

class Focontroller extends Controller
{
    public function Welcome(){
        $etelek = Etlap::where('tipus', 'Főétel')->get();
        return view('welcome', ['etelek' => $etelek]);
    }

    public function Kategoriak($tipus){
        $etelek = Etlap::where('tipus', $tipus)->get();
        return view('welcome', ['etelek' => $etelek, 'kivalasztott' => $tipus]);
    }

    public function Autocomplete(Request $request){
        $keres = $request->keres;

        $etelek = Etlap::where('termek_nev', 'like', "%$keres%")
            ->limit(5)
            ->pluck('termek_nev');

        return response()->json($etelek);
    }

    public function Kereses(Request $request){
        $q = $request->q;

        $etel = Etlap::where('termek_nev', $q)->first();
        if ($etel) {
            return view('Felhasznalo.etel', compact('etel'));
        }

        $talalatok = Etlap::where('termek_nev', 'like', "%$q%")->get();
        return view('welcome', compact('talalatok'));
    }

    public function Ajanlat(){
        $levesek = Etlap::where('tipus', 'Leves')->get();
        $foetelek = Etlap::where('tipus', 'Főétel')->get();
        $desszertek = Etlap::where('tipus', 'Desszert')->get();

        $nap = now()->dayOfYear;

        $napi_leves = $levesek[$nap % max(1, $levesek->count())] ?? null;
        $napi_foetel = $foetelek[$nap % max(1, $foetelek->count())] ?? null;
        $napi_desszert = $desszertek[$nap % max(1, $desszertek->count())] ?? null;

        return view('Felhasznalo.ajanlat', compact('napi_leves', 'napi_foetel', 'napi_desszert'));
    }

    public function Kosar(){
        return view('Felhasznalo.kosar');
    }

    public function Rendeles(){
        $etelek = Etlap::all();
        return view('Felhasznalo.rendeles', compact('etelek'));
    }

    public function KosarbaAjax(Request $request){
        $termek_nev = $request->termek_nev;
        $darab = max(1, (int)$request->darab);

        $termek = Etlap::find($termek_nev);

        if (!$termek) {
            return response()->json([
                'siker' => false,
                'hiba' => 'Nincs ilyen termék!'
            ]);
        }

        if ($darab > 20) {
            return response()->json([
                'siker' => false,
                'hiba' => 'Maximum 20 db rendelhető egy termékből!'
            ]);
        }

        $kosar = session()->get('kosar', []);

        $jelenlegiDb = 0;
        if (isset($kosar[$termek_nev])) {
            $jelenlegiDb = $kosar[$termek_nev]->term_db_szam;
        }

        $ujDb = $jelenlegiDb + $darab;

        if ($ujDb > 20) {
            return response()->json([
                'siker' => false,
                'hiba' => 'Ebből a termékből maximum 20 db lehet a kosárban!'
            ]);
        }

        if (isset($kosar[$termek_nev])) {
            $kosar[$termek_nev]->term_db_szam += $darab;
        } else {
            $ujTermek = (object) $termek->toArray();
            $ujTermek->term_db_szam = $darab;
            $ujTermek->mennyisegi_egyseg = $ujTermek->mennyisegi_egyseg ?? 'db';
            $ujTermek->kedvezmeny_szazalek = $ujTermek->akcio_szazalek ?? 0;
            $kosar[$termek_nev] = $ujTermek;
        }

        session()->put('kosar', $kosar);

        return response()->json([
            'siker' => true,
            'uzenet' => 'Kosárba rakva'
        ]);
    }

    public function Kosarba($termek_nev){
        $termek = Etlap::find($termek_nev);

        if (!$termek) {
            return back()->with('hiba', 'Nincs ilyen termék!');
        }

        $kosar = session()->get('kosar', []);

        $jelenlegiDb = 0;
        if (isset($kosar[$termek_nev])) {
            $jelenlegiDb = $kosar[$termek_nev]->term_db_szam;
        }

        $ujDb = $jelenlegiDb + 1;

        if ($ujDb > 20) {
            return back()->with('hiba', 'Ebből a termékből maximum 20 db lehet a kosárban!');
        }

        if (isset($kosar[$termek_nev])) {
            $kosar[$termek_nev]->term_db_szam += 1;
        } else {
            $ujTermek = (object) $termek->toArray();
            $ujTermek->term_db_szam = 1;
            $ujTermek->mennyisegi_egyseg = $ujTermek->mennyisegi_egyseg ?? 'db';
            $ujTermek->kedvezmeny_szazalek = $ujTermek->akcio_szazalek ?? 0;
            $kosar[$termek_nev] = $ujTermek;
        }

        session()->put('kosar', $kosar);

        return redirect('/kosar')->with('siker', 'Termék kosárba rakva!');
    }

    public function KosarTorles($termek_nev){
        $kosar = session()->get('kosar', []);

        if (isset($kosar[$termek_nev])) {
            unset($kosar[$termek_nev]);
            session()->put('kosar', $kosar);

            return back()->with('siker', 'A termék törölve lett a kosárból!');
        }

        return back()->with('hiba', 'Ez a termék nem található a kosárban!');
    }

    public function Vasarlas(Request $request){
        $alapSzabalyok = [
            'fiz_mod' => 'required|in:kezpenz,bankkartya'
        ];

        $uzenetek = [
            'required' => 'Ez a mező kötelező!',
            'email' => 'Nem valid email!',
            'digits' => 'Pontosan :digits számjegy kell!',
            'max' => 'Túl hosszú!',
            'in' => 'Érvénytelen választás!'
        ];

        if (!auth()->check()) {
            $alapSzabalyok = array_merge($alapSzabalyok, [
                'nev' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'tel_szam' => 'required|string|max:20',
                'iranyitoszam' => 'required|digits:4',
                'varos' => 'required|string|max:50',
                'utca' => 'required|string|max:50',
                'hazszam' => 'required|string|max:20',
                'emelet_ajto' => 'nullable|string|max:20',
                'megjegyzes' => 'nullable|string|max:255',
            ]);
        }

        $request->validate($alapSzabalyok, $uzenetek);

        $kosar = session('kosar', []);

        if (empty($kosar)) {
            return back()->with('hiba', 'A kosár üres');
        }

        if (auth()->check()) {
            $vevoNev = auth()->user()->nev;
            $vevoEmail = auth()->user()->email;

            $cim = Szallitasi_cim::where('email', $vevoEmail)->first();

            if (!$cim) {
                return redirect('/profil')->with('hiba', 'Előbb add meg a szállítási címed a profilban!');
            }
        } else {
            $vevoNev = $request->nev;
            $vevoEmail = $request->email;

            $teljesCim = $request->iranyitoszam . ' ' . $request->varos . ', ' . $request->utca . ' ' . $request->hazszam;
            if ($request->filled('emelet_ajto')) {
                $teljesCim .= ' ' . $request->emelet_ajto;
            }

            $felhasznalo = User::where('email', $vevoEmail)->first();

            if (!$felhasznalo) {
                $felhasznalo = User::create([
                    'nev' => $vevoNev,
                    'email' => $vevoEmail,
                    'tel_szam' => $request->tel_szam,
                    'jelszo' => Hash::make(Str::random(16)),
                    'jogosultsag' => 'felhasználó'
                ]);
        }

            $cim = Szallitasi_cim::firstOrNew(['email' => $vevoEmail]);
            $cim->cim = $teljesCim;
            $cim->megjegyzes = $request->megjegyzes;
            $cim->save();
        }

        $vegosszeg = 0;

        foreach ($kosar as $termek) {
            $brutto = $termek->netto_egyseg_ar * (1 + $termek->afa_kulcs / 100);
            $brutto *= 1 - (($termek->kedvezmeny_szazalek ?? 0) / 100);
            $brutto *= $termek->term_db_szam;
            $vegosszeg += round($brutto);
        }

        $rendeles = Rendeles::create([
            'rendeles_tipus' => 'WEB',
            'email' => $vevoEmail,
            'futar_email' => null,
            'cim_id' => $cim->cim_id,
            'fiz_mod' => $request->fiz_mod,
            'allapot' => 'kész',
            'vegosszeg' => $vegosszeg,
            'rendeles_ido' => now()
        ]);

        foreach ($kosar as $termek) {
            Kosar::create([
                'rendeles_id' => $rendeles->rendeles_id,
                'termek_nev' => $termek->termek_nev,
                'term_db_szam' => $termek->term_db_szam,
                'netto_egyseg_ar' => $termek->netto_egyseg_ar,
                'afa_kulcs' => $termek->afa_kulcs,
                'kedvezmeny_szazalek' => $termek->kedvezmeny_szazalek ?? 0,
            ]);
        }

        $utolsoSzamla = Szamla::where('szla_evszam', date('Y'))
            ->orderBy('szla_sorszam', 'desc')
            ->first();

        $ujSorszam = $utolsoSzamla ? $utolsoSzamla->szla_sorszam + 1 : 1;
        $teljesSorszam = 'TUT/' . date('Y') . '/' . str_pad($ujSorszam, 6, '0', STR_PAD_LEFT);

        Szamla::create([
            'rendeles_id' => $rendeles->rendeles_id,
            'nev' => $vevoNev,
            'cim' => $cim->cim,
            'tipus' => 'magan',
            'fiz_mod' => $request->fiz_mod === 'bankkartya' ? 'kartya' : 'kezpenz',
            'szla_nev' => 'TUT',
            'szla_evszam' => date('Y'),
            'szla_sorszam' => $ujSorszam,
            'szla_teljsorszam' => $teljesSorszam,
            'vegosszeg' => $vegosszeg
        ]);

        session()->forget('kosar');

        return redirect('/kosar')->with('siker', 'Sikeres vásárlás!');
    }

    public function Profil(){
        $osszesRendeles = Kosar::join('rendeles', 'kosar.rendeles_id', '=', 'rendeles.rendeles_id')
            ->join('etlap', 'kosar.termek_nev', '=', 'etlap.termek_nev')
            ->leftJoin('szamla', 'rendeles.rendeles_id', '=', 'szamla.rendeles_id')
            ->where('rendeles.email', auth()->user()->email)
            ->orderBy('rendeles.rendeles_id', 'desc')
            ->select(
                'kosar.*',
                'rendeles.rendeles_id',
                'rendeles.rendeles_ido',
                'rendeles.vegosszeg',
                'etlap.mennyisegi_egyseg',
                'szamla.szla_teljsorszam',
                'szamla.kibocsatas_datuma',
                'szamla.fiz_mod as szamla_fiz_mod'
            )
            ->get()
            ->groupBy('rendeles_id');

        $etelek = $osszesRendeles->take(2);
        $cim = Szallitasi_cim::where('email', auth()->user()->email)->first();

        return view('profil', [
            'etelek' => $etelek,
            'cim' => $cim,
            'vanTobbRendeles' => $osszesRendeles->count() > 2
        ]);
    }

    public function RendelesiElozmenyek(){
        $rendelesek = Rendeles::where('email', auth()->user()->email)
            ->orderBy('rendeles_id', 'asc')
            ->paginate(5);

        $rendelesIds = $rendelesek->pluck('rendeles_id');

        $termekek = Kosar::join('etlap', 'kosar.termek_nev', '=', 'etlap.termek_nev')
            ->whereIn('kosar.rendeles_id', $rendelesIds)
            ->select('kosar.*', 'etlap.mennyisegi_egyseg')
            ->get()
            ->groupBy('rendeles_id');

        $szamlak = Szamla::whereIn('rendeles_id', $rendelesIds)
            ->get()
            ->keyBy('rendeles_id');

        return view('Felhasznalo.rendelesi_elozmenyek', [
            'rendelesek' => $rendelesek,
            'termekek' => $termekek,
            'szamlak' => $szamlak
        ]);
    }

    public function Foglalas(Request $request){
        if (auth()->user()->jogosultsag === 'admin') {
            return redirect('/admin/foglalas');
        }

        if ($request->isMethod('post')) {
            if (strtotime($request->idopont) < time()) {
                return back()->with('hiba', 'Nem választhatsz múltbeli időpontot!');
            }

            $asztal = Asztalok::where('asztalszam', $request->asztalszam)->first();

            if (!$asztal) {
                return back()->with('hiba', 'Az asztal nem létezik!');
            }

            if ($request->fo_db > $asztal->fo_db) {
                return back()->with('hiba', 'Ez az asztal maximum ' . $asztal->fo_db . ' főre foglalható!');
            }

            $asztalszam = $request->asztalszam;
            $idopont = $request->idopont;
            $sor = substr($asztalszam, 0, 1);
            $oraszam = in_array($sor, ['A', 'B']) ? 2 : 3;

            $ujKezdet = strtotime($idopont);
            $ujVege = strtotime($idopont . " +{$oraszam} hours");

            $letezoFoglalasok = Helyfoglalas::where('asztalszam', $asztalszam)
                ->where('allapot', '!=', 'törölve')
                ->get();

            $legkozelebbiIdopont = null;

            foreach ($letezoFoglalasok as $foglalas) {
                $letezoKezdet = strtotime($foglalas->idopont);

                $letezoSor = substr($foglalas->asztalszam, 0, 1);
                $letezoOraszam = in_array($letezoSor, ['A', 'B']) ? 2 : 3;
                $letezoVege = strtotime($foglalas->idopont . " +{$letezoOraszam} hours");

                if ($ujKezdet < $letezoVege && $ujVege > $letezoKezdet) {
                    if ($legkozelebbiIdopont === null || $letezoVege > $legkozelebbiIdopont) {
                        $legkozelebbiIdopont = $letezoVege;
                    }
                }
            }

            if ($legkozelebbiIdopont !== null) {
                return back()->with('hiba', 'Ez az asztal már foglalt, legközelebb ekkor foglalható: ' . date('Y.m.d H:i', $legkozelebbiIdopont));
            }

            Helyfoglalas::create([
                'nev' => auth()->user()->nev,
                'email' => auth()->user()->email,
                'asztalszam' => $request->asztalszam,
                'idopont' => $request->idopont,
                'fo_db' => $request->fo_db
            ]);

            return redirect('/foglalas')->with('siker', 'Foglalás sikeres');
        }

        $datum = $request->idopont
            ? date('Y-m-d', strtotime($request->idopont))
            : now()->toDateString();

        $foglalt = Helyfoglalas::whereDate('idopont', $datum)
            ->pluck('asztalszam')
            ->toArray();

        return view('Felhasznalo.foglalas', ['foglaltAsztalok' => $foglalt]);
    }

    public function CimModositas(Request $req){
        $req->validate([
            'iranyitoszam' => 'required|digits:4',
            'varos' => 'required|max:50',
            'utca' => 'required|max:50',
            'hazszam' => 'required|max:20',
            'emelet_ajto' => 'nullable|max:20',
            'megjegyzes' => 'nullable|max:255'
        ], [
            '*.required' => 'Kérem töltse ki ezt a mezőt!',
            'iranyitoszam.digits' => 'Az irányítószám 4 számjegy legyen!'
        ]);
        $teljesCim = $req->iranyitoszam . ' ' . $req->varos . ', ' . $req->utca . ' ' . $req->hazszam;
        if ($req->filled('emelet_ajto')) {
            $teljesCim .= ' ' . $req->emelet_ajto;
        }
        $cim = Szallitasi_cim::where('email', Auth::user()->email)->first();
        if (!$cim) {
            $cim = new Szallitasi_cim();
            $cim->email = Auth::user()->email;
        }
        $cim->cim = $teljesCim;
        $cim->megjegyzes = $req->megjegyzes;
        $cim->save();
        return back()->with('siker', 'Szállítási cím sikeresen módosítva!');
    }

    public function SzamlaMegtekintes($rendeles_id){
        $rendeles = Rendeles::where('rendeles_id', $rendeles_id)
            ->where('email', auth()->user()->email)
            ->first();

        if (!$rendeles) {
            return redirect('/profil')->with('hiba', 'Ez a számla nem található!');
        }

        $szamla = Szamla::where('rendeles_id', $rendeles_id)->first();

        if (!$szamla) {
            return redirect('/profil')->with('hiba', 'Ehhez a rendeléshez nincs számla!');
        }

        $tetelLista = Kosar::where('rendeles_id', $rendeles_id)->get();

        $afaOsszesen = 0;
        $nettoOsszesen = 0;
        $bruttoOsszesen = 0;

        foreach ($tetelLista as $tetel) {
            $netto = $tetel->netto_egyseg_ar * $tetel->term_db_szam;
            $kedvezmeny = $netto * (($tetel->kedvezmeny_szazalek ?? 0) / 100);
            $nettoKedvezmennyel = $netto - $kedvezmeny;

            $afa = $nettoKedvezmennyel * ($tetel->afa_kulcs / 100);
            $brutto = $nettoKedvezmennyel + $afa;

            $tetel->szamitott_netto = round($nettoKedvezmennyel);
            $tetel->szamitott_afa = round($afa);
            $tetel->szamitott_brutto = round($brutto);

            $nettoOsszesen += round($nettoKedvezmennyel);
            $afaOsszesen += round($afa);
            $bruttoOsszesen += round($brutto);
        }

        $cim = Szallitasi_cim::where('cim_id', $rendeles->cim_id)->first();

        return view('szamla', [
            'rendeles' => $rendeles,
            'szamla' => $szamla,
            'tetelLista' => $tetelLista,
            'cim' => $cim,
            'nettoOsszesen' => $nettoOsszesen,
            'afaOsszesen' => $afaOsszesen,
            'bruttoOsszesen' => $bruttoOsszesen
        ]);
    }
}
