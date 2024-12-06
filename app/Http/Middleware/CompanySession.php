<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Company;
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
        if(!session()->has('companies')) {
            $companies = Company::select('id', 'name', 'acronym')->get();
            session()->forget('companies');
            session(['companies' => $companies->toArray()]);
        }
        // Validad si existe una sesión con los datos de una razon social de las dos opciones que tiene el sistema
        if (session()->has('company_id') && session()->has('company_name')) {
            return $next($request);
        } else {
            $company = Company::first();
            session()->forget(['company_id', 'company_name']);
            session([
                'company_id' => $company->id,
                'company_name' => $company->short_name,
                'company_acronym' => $company->acronym,
            ]);
        }
        return $next($request);
    }
}
