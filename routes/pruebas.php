<?php

use Money\Currency;
use App\Models\User;
use App\Models\Category;
use App\Models\Management;
use App\Models\CategoryFamily;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PurchaseProvider;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequisition;
use Money\Currencies\ISOCurrencies;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\PurchaseRequisitionApprovalChain;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

Route::get('excel', function () {

    // $type = 'DN-NP';
    // $type = 'Stock';
    $type = 'Servicios generales';
    $collection = fastexcel()->import('data.xlsx');
    $collection =  $collection->groupBy('CATEGORIA');
    // $collection =  $collection->groupBy('CATEGORÍA');


    $array = [];
    foreach ($collection as $key => $value) {
        $category = Category::where('name', str($key)->lower())->first();
        // dump('KEY:'.$key, 'DB:'.$category?->name);
        foreach ($value as $k => $v) {
            $array[] = [
                'name' => str($v['DESCRIPCIÓN'])->squish(),
                'code' => $v['N° FAM.'],
                'type' => $type,
                'category_id' => $category->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    }
    // return true;
    $collec = collect($array);
    $collec = $collec->sortBy('category_id');
    // dd($collec->values()->all());

    DB::beginTransaction();
    try {
        DB::table('category_families')->insert($collec->toArray());
        DB::afterCommit(function () use ($collec) {
            echo 'Se insertaron familias';
        });
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        return $e->getMessage();
    }
});

Route::get('change-category', function () {
    $categoryFamilies = CategoryFamily::all();

    foreach ($categoryFamilies as $item) {
        $item->name = str($item->name)->lower();
        $item->save();
    }
});


Route::get('media-test', function () {
    $collection_name = 'technical_data_sheets';
    $media =  Media::where('model_id', 2)
        ->where('collection_name', $collection_name)->count();

    return $media;
});

// TODO: este codigo  es para reenviar un correo dependiendo el status de una requisicion
Route::get('history', function () {
    $model = PurchaseProvider::find(1);
    $afterTransitionHooks = $model->status()->stateMachine()->afterTransitionHooks();
    dd($afterTransitionHooks);
    $afterTransitionHooks('', $model);
});
Route::get('items', function () {
    $model = PurchaseRequisition::find(3);
    dd($model->responsiblePurchaseOrder);
});

Route::get('change-status', function () {
    $model = PurchaseRequisition::find(1);
    $model->status = 'aprobado por DG';
    $model->save();
});

Route::get('management-user', function () {
    $user = User::approvers()->get();
    $management = Management::all()->pluck('responsible_id')->unique();
    dd($user->toArray(), $management);
    $user = User::withWhereHas('management', function ($query) {})->get();
    // return $user;
});

Route::get('chains', function () {
    // $user= User::with(['approverChainsPR'])->find(331);
    try {
        $user = auth()->user();
        $user->notify(
            Notification::make()
                ->title('Revisar existencias de requisicion')
                ->toDatabase()
        );
    } catch (\Exception $e) {
        dd($e->getMessage());
    }
});

Route::get('flatMap', function () {
    $rq = PurchaseRequisition::with('items')->first();
    if (filled($rq->orders)) {
        $flattened = $rq->orders->flatMap(function ($values) {
            return $values->items;
        });
        return $flattened->pluck('product_id');
    } else {
        return null;
    }
});

Route::get('rq-order', function () {
    $rq = PurchaseRequisition::find(1);
    return $rq->orders;
});

Route::get('money', function () {
    $currencies = new ISOCurrencies();
    foreach ($currencies as $currency) {
        echo '<br>';
        echo $currency->getCode(); // prints an available currency code within the repository
        echo '<br>';
    }
});

Route::get('pdf-order', function () {

      // TODO:falta limitar para solo los que esten relacionados con esta requisicion puedan verla
      $rq = PurchaseRequisition::with(['items','approvalChain','project','items.product','items.product.unit','company'])->findOrFail(1);
      // dd($rq->toArray());
      // return view('pdf.purchase-order',compact('rq'));
      // $m1= $rq->getMedia('supports');
      // $m2= $rq->getMedia('technical_data_sheets');
      // dd($m1->toArray(),$m2->toArray());
      $pdf = Pdf::loadView('pdf.purchase-order',compact('rq'));
      return $pdf->stream($rq->folio.'.pdf');
});
