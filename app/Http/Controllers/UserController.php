<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Szallitasi_cim;

class UserController extends Controller
{
    public function Reg(){
        if (Auth::check()) {
            return redirect('/profil');
        }

        return view('Felhasznalo.reg');
    }

    public function RegButton(Request $req){
        $req->validate([
            'nev' => 'required|min:3|max:255',
            'email' => 'required|email|unique:felhasznalo,email',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->mixedCase()->symbols()->uncompromised()],
            'password_confirmation' => 'required',
            'tel_szam' => ['required', 'regex:/^(\+36|06)(20|30|70)\d{7}$/'],
            'iranyitoszam' => 'required|digits:4',
            'varos' => ['required', 'max:50', 'regex:/^[\pL\s-]+$/u'],
            'utca' => ['required', 'max:50', 'regex:/^[\pL\s.-]+$/u'],
            'hazszam' => 'required|max:20',
            'emelet_ajto' => 'nullable|max:20',
            'megjegyzes' => 'nullable|max:255'
        ], [
            '*.required' => 'Kérem töltse ki ezt a mezőt!',
            'email.email' => 'Kérem adjon meg egy érvényes e-mail címet!',
            'email.unique' => 'Ez az e-mail cím már foglalt!',
            'password.confirmed' => 'A két jelszó nem egyezik meg!',
            'password.uncompromised' => 'Ez a jelszó amit megadott az már kiszivárgott az adatbázisból, kérem adjon meg mást!',
            'tel_szam.regex' => 'Helyes formátum: +36301234567 vagy 06301234567',
            'iranyitoszam.digits' => 'Az irányítószám 4 számjegy legyen!',
            'varos.regex' => 'A város neve csak betűket tartalmazhat!',
            'utca.regex' => 'Az utca neve csak betűket tartalmazhat!'
        ]);

        $user = new User();
        $user->nev = $req->nev;
        $user->email = $req->email;
        $user->jelszo = Hash::make($req->password);
        $user->tel_szam = $req->tel_szam;
        $user->jogosultsag = 'felhasználó';
        $user->futar_jelentkezes = $req->has('futar_jelentkezes') ? 1 : 0;
        $user->futar_elfogadva = 0;
        $user->save();

        $teljesCim = $req->iranyitoszam . ' ' . $req->varos . ', ' . $req->utca . ' ' . $req->hazszam;
        if ($req->filled('emelet_ajto')) {
            $teljesCim .= ' ' . $req->emelet_ajto;
        }

        $cim = new Szallitasi_cim();
        $cim->email = $req->email;
        $cim->cim = $teljesCim;
        $cim->megjegyzes = $req->megjegyzes;
        $cim->save();

        Auth::login($user);

        if ($user->futar_jelentkezes == 1) {
            return redirect('/profil')->with('siker', 'Sikeres regisztráció! A futár jelentkezésed jóváhagyásra vár.');
        }

        return redirect('/profil')->with('siker', 'Sikeres regisztráció!');
    }

    public function Login(){
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->jogosultsag === 'admin') {
                return redirect('/admin');
            }

            if ($user->jogosultsag === 'futár') {
                return redirect('/futar/profil');
            }

            return redirect('/profil');
        }

        return view('login');
    }

    public function LoginButton(Request $req){
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            '*.required' => 'Kérem töltse ki ezt a mezőt!'
        ]);

        if (!Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
            return redirect('/login')->with('kudarc', 'Hibás e-mail cím vagy jelszó!');
        }

        $req->session()->regenerate();

        $user = Auth::user();

        if ($user->futar_jelentkezes == 1 && $user->futar_elfogadva == 0) {
            Auth::logout();
            return redirect('/login')->with('kudarc', 'A futár jelentkezésed még admin jóváhagyásra vár!');
        }

        if ($user->jogosultsag === 'admin') {
            return redirect('/admin')->with('siker', 'Admin belépés sikeres!');
        }

        if ($user->jogosultsag === 'futár') {
            return redirect('/futar/profil')->with('siker', 'Futár belépés sikeres!');
        }

        return redirect('/profil')->with('siker', 'Sikeres belépés!');
    }

    public function Logout(){
        Auth::logout();
        return redirect('/login');
    }

    public function Newpass(){
        return view('newpass');
    }

    public function NewpassButton(Request $req){
        $validator = Validator::make($req->all(), [
            'oldpassword' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->mixedCase()->symbols()->uncompromised()],
            'password_confirmation' => 'required'
        ], [
            '*.required' => 'Kérem töltse ki ezt a mezőt!',
            'password.confirmed' => 'A két jelszó nem egyezik meg!',
            'password.uncompromised' => 'Ez a jelszó amit megadott az már kiszivárgott az adatbázisból, kérem adjon meg mást!'
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('password')) {
                return back()
                    ->with('kudarc', $validator->errors()->first('password'))
                    ->withErrors($validator)
                    ->withInput();
            }

            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        if (!Hash::check($req->oldpassword, $user->jelszo)) {
            return back()->with('kudarc', 'A régi jelszó hibás!');
        }

        if ($req->oldpassword == $req->password) {
            return back()->with('kudarc', 'A régi és az új jelszó nem lehet ugyanaz!');
        }

        $user->jelszo = Hash::make($req->password);
        $user->save();

        return redirect('/profil')->with('siker', 'Jelszó sikeresen módosítva!');
    }

    public function Profilkep(Request $request){
        $validator = Validator::make($request->all(), [
            'profil_kep' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'profil_kep.required' => 'Kérem válasszon ki egy képet!',
            'profil_kep.image' => 'Csak képfájlt tölthet fel!',
            'profil_kep.mimes' => 'Csak JPG, JPEG vagy PNG formátum engedélyezett!',
            'profil_kep.max' => 'A profilkép maximum 2 MB lehet!'
        ]);

        if ($validator->fails()) {
            return back()->with('hiba', $validator->errors()->first());
        }

        $file = $request->file('profil_kep');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('img'), $filename);

        $user = Auth::user();
        $user->profil_kep = $filename;
        $user->save();

        return back()->with('siker', 'Profilkép frissítve!');
    }
}
