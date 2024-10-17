<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequisition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Models\PurchaseRequisitionApprovalChain;

Route::get('tablas', function () {

    $tablas = DB::select('SHOW TABLES');
    // //  Convertir el resultado en un array asociativo
    $tablas = array_map('current', json_decode(json_encode($tablas), true));
    // return ($tablas);

    //array con el nombre de las tablas
    // $tablas = [
    //     "epp_equipo_entregados",
    //     "equipos",
    //     "equipos_asignacion",
    //     "failed_jobs",
    //     "kpi_avance",
    //     "kpis",
    //     "media",
    //     "migrations",
    //     "model_has_permissions",
    //     "model_has_roles",
    //     "orden_mantenimiento_user",
    //     "orden_mantenimientos",
    //     "password_resets",
    //     "pending_transitions",
    //     "permissions",
    //     "personal_access_tokens",
    //     "producto_categorias",
    //     "producto_entradas",
    //     "productos",
    //     "razones_sociales",
    //     "reporte_mantenimientos",
    //     "responsivas",
    //     "role_has_permissions",
    //     "roles",
    //     "state_histories",
    //     "ticket_epp_equipo",
    //     "ticket_epps",
    //     "tickets_it",
    //     "tickets_mantenimiento",
    //     "users"
    // ];
    try {
        foreach ($tablas as $tabla) {
            $comando = 'iseed ' . $tabla . ' --force';
            $exitCode = Artisan::call($comando);
            echo '<br>';
            echo $exitCode;
        }
    } catch (\Exception $e) {
        throw $e;
    }
    // php artisan iseed users --force
});

Route::get('procesos', function () {
    $procesos = [
        ['Administración y Contabilidad', 'ADM'],
        ['Almacén', 'ALM'],
        ['Calidad, Seguridad y Medio Ambiente', 'QHSE'],
        ['Compras', 'COM'],
        ['Ingeniería - Manufactura', 'ING'],
        ['Mantenimiento', 'MTTO'],
        ['Marketing', 'MKT'],
        ['Región Sur', 'GRS'],
        ['Norte Región Centro', 'GRC'],
        ['Planeación', 'CP'],
        ['Recursos Humanos', 'RH'],
        ['Servicios Generales', 'SG'],
        ['Ventas', 'VEN'],
        ['Soldadura', 'ISW'],
        ['Servicios Complementarios', 'SC'],
        ['Servicios Técnicos', 'ST'],
        ['Informática', 'IT']
    ];

    foreach ($procesos as $key => $proceso) {
        DB::table('management')->insert([
            'id' => $key + 1,
            'name' => $proceso[0],
            'acronym' => $proceso[1],
            'responsible_id' => 106,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
});

Route::get('um', function () {
    $unidades_de_medida = array(
        "metros" => "m",
        "centímetros" => "cm",
        "milímetros" => "mm",
        "kilómetros" => "km",
        "gramos" => "g",
        "kilogramos" => "kg",
        "toneladas" => "t",
        "litros" => "L",
        "mililitros" => "mL",
        "pulgadas" => "in",
        "pies" => "ft",
        "yardas" => "yd",
        "millas" => "mi",
        "millas náuticas" => "nmi",
        "segundos" => "s",
        "minutos" => "min",
        "horas" => "h",
        "días" => "d",
        "semanas" => "wk",
        "años" => "y",
        "julios" => "J",
        "calorías" => "cal",
        "vatios" => "W",
        "kilovatios" => "kW",
        "voltios" => "V",
        "amperios" => "A",
        "ohmios" => "Ω",
        "newtons" => "N",
        "pascales" => "Pa",
        "barras" => "bar",
        "atmósferas" => "atm",
        "hectáreas" => "ha",
        "acres" => "ac",
        "litros por kilómetro" => "L/km",
        "kilómetros por hora" => "km/h",
        "metros por segundo" => "m/s",
        "grados Celsius" => "°C",
        "grados Fahrenheit" => "°F",
        "kelvin" => "K",
        "radianes" => "rad",
        "hercios" => "Hz",
        "lúmenes" => "lm",
        "lux" => "lx",
        "becquerel" => "Bq",
        "grays" => "Gy",
        "sieverts" => "Sv",
    );

    foreach ($unidades_de_medida as $key => $um) {
        DB::table('measure_units')->insert([
            'name' => $key,
            'acronym' => $um,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
});


Route::get('id/{id}', function ($id) {
    $user = User::findOrFail($id);
    Auth::login($user, $remember = true);
    setCompany(1, false);
});


function setCompany($id, $redirect = true)
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

Route::get('cadenas', function () {
   $rq = PurchaseRequisition::first();
   dd($rq->status()->stateMachine()->transitions());

});
