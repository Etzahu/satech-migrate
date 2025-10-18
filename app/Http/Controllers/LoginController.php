<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\TicketIT;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

use Filament\Facades\Filament;

use Filament\Notifications\Notification;

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

        $this->setCompany(2, false);
        return redirect()->route('filament.compras.pages.dashboard');
        // if ($request->session()->has('intended_url')) {
        //     $intended_url = $request->session()->get('intended_url');
        //     $request->session()->forget('intended_url');
        //     return redirect()->to($intended_url);
        // } else {
        //     return redirect()->route('filament.compras.pages.dashboard');
        // }
    }

    public function logout()
    {
        Filament::auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    public function setCompany($id, $redirect = true)
    {
        $companies = Company::select('id', 'name', 'short_name', 'acronym')->get();
        session()->forget('companies');
        session(['companies' => $companies->toArray()]);
        $company = Company::findOrFail($id);
        session()->forget(['company_id', 'company_name']);
        session([
            'company_id' => $company->id,
            'company_name' => $company->name,
            'company_acronym' => $company->acronym,
        ]);

        Notification::make()
            ->title('Se ha cambiado la empresa')
            ->success()
            ->iconColor('success')
            ->icon('heroicon-m-building-office-2')
            ->send();
        // return redirect()->to(url()->previous());
        return redirect('/compras');
    }
}
