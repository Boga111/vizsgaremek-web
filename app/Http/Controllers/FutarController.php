<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rendeles;
use App\Models\Szallitasi_cim;

class FutarController extends Controller
{
    public function CimekHozzaadasa($rendelesek){
        foreach ($rendelesek as $rendeles) {
            $cim = Szallitasi_cim::where('cim_id', $rendeles->cim_id)->first();

            $rendeles->cim = $cim ? $cim->cim : null;
            $rendeles->megjegyzes = $cim ? $cim->megjegyzes : null;
        }

        return $rendelesek;
    }

    public function Profil(){
        $fuvarok = Rendeles::where('futar_email', auth()->user()->email)
            ->where('allapot', 'kiszallitva')
            ->orderBy('rendeles_id', 'desc')
            ->get();

        $fuvarok = $this->CimekHozzaadasa($fuvarok);

        return view('Futar.futar_profil', compact('fuvarok'));
    }

    public function Attekintes(){
        $elvallalhato = Rendeles::whereNotNull('cim_id')
            ->whereNull('futar_email')
            ->where('allapot', 'kész')
            ->orderBy('rendeles_id', 'desc')
            ->limit(10)
            ->get();

        $elvallalhato = $this->CimekHozzaadasa($elvallalhato);

        return view('Futar.futar_attekintes', compact('elvallalhato'));
    }

    public function Cimek(){
        $etteremCim = 'Budapest, Üteg u. 15, 1139';

        $cimek = Rendeles::whereNotNull('cim_id')
            ->whereNull('futar_email')
            ->where('allapot', 'kész')
            ->orderByDesc('rendeles_id')
            ->get();

        $cimek = $this->CimekHozzaadasa($cimek);

        foreach ($cimek as $rendeles) {
            $rendeles->etterem_cim = $etteremCim;
            $rendeles->utvonal_link = 'https://www.google.com/maps/dir/?api=1&origin='
                . urlencode($etteremCim)
                . '&destination='
                . urlencode($rendeles->cim ?? '')
                . '&travelmode=driving';
        }

        return view('Futar.futar_cimek', compact('cimek'));
    }

    public function Elvallal($rendeles_id){
        $rendeles = Rendeles::where('rendeles_id', $rendeles_id)
            ->whereNull('futar_email')
            ->where('allapot', 'kész')
            ->first();

        if (!$rendeles) {
            return back()->with('hiba', 'Ezt már elvitte valaki');
        }

        $rendeles->allapot = 'uton';
        $rendeles->futar_email = auth()->user()->email;
        $rendeles->save();

        return redirect('/futar/sajat')->with('siker', 'Elvállalva');
    }

    public function Sajat(){
        $fuvarok = Rendeles::where('futar_email', auth()->user()->email)
            ->whereIn('allapot', ['uton', 'kiszallitva'])
            ->orderByDesc('rendeles_id')
            ->get();

        $fuvarok = $this->CimekHozzaadasa($fuvarok);

        return view('Futar.futar_sajat', compact('fuvarok'));
    }

    public function Allapot(Request $request, $id){
        $request->validate([
            'allapot' => 'required|in:uton,kiszallitva'
        ]);

        $rendeles = Rendeles::where('rendeles_id', $id)
            ->where('futar_email', auth()->user()->email)
            ->first();

        if (!$rendeles) {
            return back()->with('hiba', 'Ezt a fuvart nem te vállaltad el');
        }

        $rendeles->allapot = $request->allapot;
        $rendeles->save();

        return back()->with('siker', 'Állapot mentve');
    }
}