<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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
