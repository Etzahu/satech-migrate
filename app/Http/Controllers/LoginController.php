<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TicketIT;
use App\Services\DashboardService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {

        if (Auth::check()) {
            return redirect()->route('filament.compras.pages.dashboard');
        }
        return view('authentication.login');
    }
    public function redirectToProvider()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        try {
            $userGoogle = Socialite::driver('google')->user();
            // Validar si existe el usuario que viene de google en la tabla USERS
            $user = User::where('email', $userGoogle->email)
                ->where('active', 1)
                ->first();

            if (is_null($user)) {
                return redirect()->route('login');
            }
            Auth::login($user, $remember = true);
        } catch (\Throwable $th) {
            return redirect()->route('login');
        }

        $this->setCompany(1, false);
        if ($request->session()->has('intended_url')) {
            $intended_url = $request->session()->get('intended_url');
            $request->session()->forget('intended_url');
            return redirect()->to($intended_url);
        } else {
            return redirect()->route('filament.compras.pages.dashboard');
        }
    }


    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }

    public function setCompany($id, $redirect = true)
    {
        session()->forget(['company_id', 'company_name', 'logo']);
        if ($id == 1) {
            session([
                'company_id' => 1,
                'company_name' => 'GPT INGENIERIA Y MANUFACTURA',
                'logo' => 'https://lh3.googleusercontent.com/oMpAslP5lCZ8ufvC4sIGfsaIR2BrZu6ee-ekhSmOEtYPSgXGqFYpRBBN99VcFN4zAXVKD6Tv4WQi4kgWHee38Ttm7uwm8j31zNZqgHVHpx4PeZpgIhmt_fySFS5S60rZz-aYnr8OiA'
            ]);
        }
        if ($id == 2) {
            session([
                'company_id' => 2,
                'company_name' => 'TECH ENERGY CONTROL',
                'logo' => 'https://lh3.googleusercontent.com/693EmbDOU1QkzkumTJgTeRKUtuVD93wX_u_YrIzJlHra0qqgEebRqAaLSUtl3sUppJs7jGL6-sfvTjHizjojMdR9Q4MVFaps5F4H7xiBEjUB6xBhDwdvlXUsLFgkM5OdcwC71LImfw'
            ]);
        }
        if ($redirect) {
            return redirect()->back();
        }
    }
}
