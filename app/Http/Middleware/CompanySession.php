<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanySession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Validad si existe una sesión con los datos de una razon social de las dos opciones que tiene el sistema
        if (session()->has('company_id') && session()->has('company_name')) {
            return $next($request);
        } else {
            session([
                'company_id' => 1,
                'company_name' => 'GPT INGENIERIA Y MANUFACTURA',
                'logo' => 'https://lh3.googleusercontent.com/oMpAslP5lCZ8ufvC4sIGfsaIR2BrZu6ee-ekhSmOEtYPSgXGqFYpRBBN99VcFN4zAXVKD6Tv4WQi4kgWHee38Ttm7uwm8j31zNZqgHVHpx4PeZpgIhmt_fySFS5S60rZz-aYnr8OiA'
            ]);
        }
        return $next($request);
    }
}
