<?php

use Money\Money;
use Carbon\Carbon;
use Money\Currency;
use App\Models\User;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use App\Models\Management;
use App\Models\MeasureUnit;
use App\Models\PurchaseOrder;
use App\Models\CategoryFamily;
use App\Models\ProjectPurchase;
use App\Models\ProviderContact;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PurchaseProvider;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequisition;

use Money\Currencies\ISOCurrencies;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Rap2hpoutre\FastExcel\FastExcel;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use App\Services\OrderCalculationService;
use Rap2hpoutre\FastExcel\SheetCollection;
use function Spatie\LaravelPdf\Support\pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\PurchaseRequisitionApprovalChain;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Mail\PurchaseOrder\Notification as NotificationOrder;

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
    return redirect()->route('filament.compras.pages.dashboard');
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

    $type = 'DN-NP';
    // $type = 'Stock';
    $type = 'Servicios generales';
    $collection = fastexcel()->import('clasificacion.xlsx');
    // $collection =  $collection->groupBy('CATEGORÍAS');
    $collection =  $collection->groupBy('CATEGORIAS');
    // return $collection;

    $array = [];
    foreach ($collection as $key => $value) {
        $category = Category::where('name', str($key)->lower())->first();
        // dump('KEY:'.$key, 'DB:'.$category?->name);
        foreach ($value as $k => $v) {
            $array[] = [
                'name' => str($v['DESCRIPCIÓN'])->squish(),
                'code' => $v['FAM'],
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
    $rq = PurchaseRequisition::find(1);
    dd($rq->getMedia('supports'));
    $media =  Media::where('model_id', 2)
        ->where('collection_name', $collection_name)->count();

    return $media;
});

// TODO: este codigo  es para reenviar un correo dependiendo el status de una requisicion
Route::get('history', function () {
    // $model = PurchaseProvider::find(1);
    $model = PurchaseOrder::first();
    $afterTransitionHooks = $model->status()->stateMachine()->transitions();

    $afterTransitionHooks = collect($afterTransitionHooks)->flatten()->unique();

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

    $data = PurchaseOrder::with(['company', 'requisition', 'provider', 'providerContact', 'items', 'items.product', 'items.product.unit', 'items.product.brand', 'purchaser'])->first();
    // return $data;
    $service = new OrderCalculationService($data->id);
    $items = $data->items;
    $media[] = $data->getMedia('justification')->first();
    $media[] = $data->getMedia('direct_award')->first();
    $media[] = $data->getMedia('certifications')->first();
    $media[] = $data->getMedia('quote')->first();

    $itemsFormatted = $items->map(function ($item) use ($data, $service) {
        $unitPrice =  new Money($item->unit_price, new Currency($data->currency));
        $subTotal =  new Money($item->sub_total, new Currency($data->currency));
        return [
            'code' => $item->product->code,
            'name' => $item->product->name,
            'brand' => $item->product->brand?->name,
            'unit' => $item->product->unit->acronym,
            "quantity" => $item->quantity,
            "unit_price" => $service->moneyFormatter($unitPrice),
            "sub_total" => $service->moneyFormatter($subTotal),
            "observation" => $item->observation,
        ];
    });
    $total = [
        'Subtotal' =>  $service->getSubtotalItems(true),
        'Descuento' =>  $service->getDiscountProvider(true),
        'IVA' =>  $service->getTaxIva(true),
        'Retención de IVA' =>  $service->getRetentionIva(true),
        'Retención de ISR' =>  $service->getRetentionIsr(true),
        'Total' =>  $service->getTotal(true),
    ];


    $data['total'] = $total;
    $data['media'] = $media;
    $data['itemsFormatted'] = $itemsFormatted;


    // return $data;
    // Mail::to('ahernandezm@gptservices.com')->send(new NotificationOrder($data));
    // return view('pdf.purchase-order.header', compact('data'));
    return pdf()
        ->view('pdf.purchase-order.content', ['data' => $data])
        ->margins(40, 15, 15, 15)
        ->headerView('pdf.purchase-order.header', ['data' => $data])
        ->withBrowsershot(function (Browsershot $browsershot) {
            $browsershot
                ->noSandbox()
                ->writeOptionsToFile();
        })
        ->disk('public')
        ->save('orden-compra.pdf')
        ->name('invoice-2023-04-10.pdf');

    // TODO:falta limitar para solo los que esten relacionados con esta requisicion puedan verla
    $rq = PurchaseRequisition::with(['items', 'approvalChain', 'project', 'items.product', 'items.product.unit', 'company'])->findOrFail(1);

    // dd($rq->toArray());

});

Route::get('total', function () {

    $rq = PurchaseOrder::find(1);
    $service = new OrderCalculationService($rq->id);
    $service->getSubtotalItems();
    $service->getTaxIva();
    $service->getRetentionIva();
    $service->getRetentionIsr();
    $service->getTotal();
});

Route::get('res', function () {

    $orders = PurchaseOrder::withWhereHas('requisition.approvalChain', function ($query) {
        $query->where('approver_id', auth()->user()->id);
    })
        ->where('status', 'aprobado por gerente de compras')
        ->get();


    return $orders;
});

Route::get('hasRole', function () {
    $user = User::find(199);
    dump($user->hasRole('gerente_solicitante_orden_compra'));
    $user2 = User::find(19);
    dump($user2->hasRole('gerente_solicitante_orden_compra'));
});

Route::get('mana', function () {
    $user = User::with('management')->find(199);
    dd($user->toArray());
});


Route::get('credencial', function () {
    // return view('pdf.purchase-order.content');
    return pdf()
        ->view('test')
        ->landscape()
        ->margins(0, 0, 0, 0)
        ->paperSize(54, 86, 'mm')
        ->withBrowsershot(function (Browsershot $browsershot) {
            $browsershot
                ->noSandbox()
                ->writeOptionsToFile();
        })
        ->name('invoice-2023-04-10.pdf');

    // TODO:falta limitar para solo los que esten relacionados con esta requisicion puedan verla
    $rq = PurchaseRequisition::with(['items', 'approvalChain', 'project', 'items.product', 'items.product.unit', 'company'])->findOrFail(1);

    // dd($rq->toArray());
    return view('pdf.purchase-order', compact('rq'));
    // $m1= $rq->getMedia('supports');
    // $m2= $rq->getMedia('technical_data_sheets');
    // dd($m1->toArray(),$m2->toArray());
    $pdf = Pdf::loadView('pdf.purchase-order', compact('rq'));
    return $pdf->stream($rq->folio . '.pdf');
});

Route::get('test-rq', function () {
    $rq = PurchaseRequisition::all();
    dd($rq->approve());
});
Route::get('migraciones', function () {

    $collection = fastexcel()->import('migraciones-2.xlsx');

    $users = User::all();

    try {
        DB::beginTransaction();
        foreach ($collection as $item) {
        }
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        throw new \Exception($e->getMessage());
    }
});

Route::get('users-migrate', function () {
    $users = array(
        array('id' => '13', 'nombre' => 'Benjamín Alcántara Bautista', 'email' => 'balcantarab@gptservices.com', 'phone' => '(+52) 55 8096 0795', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692116993/fotos/13.png', 'active' => '1', 'name' => 'Ayudante Especializado'),
        array('id' => '14', 'nombre' => 'Jesús Becerra Yebra', 'email' => 'jbecerray@gptservices.com', 'phone' => '(+52) 55 3034 8643', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690912320/fotos/14.jpg', 'active' => '1', 'name' => 'Técnico Soldador Master'),
        array('id' => '18', 'nombre' => 'Ana Lilia López Arreola', 'email' => 'alopeza@gptservices.com', 'phone' => '(+52) 55 8108 6378', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117013/fotos/18.png', 'active' => '1', 'name' => 'Encargada Administrativa'),
        array('id' => '19', 'nombre' => 'Rafael García Arroyo', 'email' => 'rgarciaa@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117036/fotos/19.png', 'active' => '1', 'name' => 'Gerencia de Ingeniería y Manufactura'),
        array('id' => '22', 'nombre' => 'Iván Ponce Reyes', 'email' => 'iponcer@gptservices.com', 'phone' => '(+52) 55 8103 0124', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1695745668/fotos/22.jpg', 'active' => '1', 'name' => 'Técnico Especialista en HT & LS Nivel III'),
        array('id' => '26', 'nombre' => 'Sinhue Ulloa Tello', 'email' => 'sulloat@gptservices.com', 'phone' => '(+52) 55 5953 7883', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117102/fotos/26.png', 'active' => '1', 'name' => 'Técnico Especialista en Soldadura'),
        array('id' => '36', 'nombre' => 'Guillermo Gutiérrez Melo', 'email' => 'ggutierrezm@gptservices.com', 'phone' => '(+52) 55 8097 1226', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1696437610/fotos/36.jpg', 'active' => '1', 'name' => 'Gerencia Técnica'),
        array('id' => '37', 'nombre' => 'Luis Reyes Yáñez', 'email' => 'lreyesy@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690912252/fotos/37.png', 'active' => '1', 'name' => 'Mecánico Tornero'),
        array('id' => '40', 'nombre' => 'Fernando Basave Arce', 'email' => 'febasavea@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1694462739/fotos/40.png', 'active' => '1', 'name' => 'Ingeniero de proyectos'),
        array('id' => '46', 'nombre' => 'Aquiles Gonzalo García Montiel', 'email' => 'agarciam@gptservices.com', 'phone' => '(+52) 55 5965 6833', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690912357/fotos/46.jpg', 'active' => '1', 'name' => 'Jefatura de Contratos Gobierno'),
        array('id' => '50', 'nombre' => 'Aurelio Cruz Báez', 'email' => 'acruzb@gptservices.com', 'phone' => '(+52) 55 7667 3044', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1694462819/fotos/50.png', 'active' => '1', 'name' => 'Técnico Especialista en HT & LS Nivel I'),
        array('id' => '53', 'nombre' => 'Adriana González Huitrón', 'email' => 'agonzalezh@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117203/fotos/53.png', 'active' => '1', 'name' => 'Ingeniería'),
        array('id' => '64', 'nombre' => 'Luis Sandoval Cabello', 'email' => 'lsandovalc@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690998806/fotos/64.jpg', 'active' => '1', 'name' => 'Mecánico Especialista'),
        array('id' => '89', 'nombre' => 'Juan Jiménez Camacho', 'email' => 'jjimenezc@gptservices.com', 'phone' => '(+52) 4721 270293', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117241/fotos/89.png', 'active' => '1', 'name' => 'Técnico Soldador'),
        array('id' => '92', 'nombre' => 'Néstor Adair Acosta Arroyo', 'email' => 'naacostaa@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117274/fotos/92.png', 'active' => '1', 'name' => 'Técnico Especialista en HT & LS Nivel II'),
        array('id' => '99', 'nombre' => 'Raúl Rodríguez Guzmán', 'email' => 'rrodriguezg@gptservices.com', 'phone' => '(+52) 55 3513 4163', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690998881/fotos/99.jpg', 'active' => '1', 'name' => 'Técnico Soldador'),
        array('id' => '106', 'nombre' => 'Denise Marisol Reyes Ramírez', 'email' => 'dmreyesr@gptservices.com', 'phone' => '(+52) 55 8097 1232', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117322/fotos/106.png', 'active' => '1', 'name' => 'Dirección General'),
        array('id' => '114', 'nombre' => 'Manuel Antonio Ríos Cuautitla', 'email' => 'mariosc@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117344/fotos/114.png', 'active' => '1', 'name' => 'Diseñador'),
        array('id' => '120', 'nombre' => 'Roberto González Muñoz', 'email' => 'rgonzalezm@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117370/fotos/120.jpg', 'active' => '1', 'name' => 'Manufactura'),
        array('id' => '123', 'nombre' => 'Angélica Salgado Zúñiga', 'email' => 'asalgadoz@gptservices.com', 'phone' => '(+52) 55 6703 9366', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690912375/fotos/123.jpg', 'active' => '1', 'name' => 'Recursos Humanos Sr'),
        array('id' => '131', 'nombre' => 'Axel Javier Martínez Segura', 'email' => 'ajmartinezs@gptservices.com', 'phone' => '(+52) 55 5188 2957', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1694462914/fotos/131.png', 'active' => '1', 'name' => 'Técnico Soldador'),
        array('id' => '132', 'nombre' => 'Martín Paes Santillán', 'email' => 'mpaess@gptservices.com', 'phone' => '(+52) 55 7786 2987', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117394/fotos/132.png', 'active' => '1', 'name' => 'Ayudante de Soldador'),
        array('id' => '137', 'nombre' => 'Luis Jesús Godínez Rivera', 'email' => 'lgodinez@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1695745751/fotos/137.jpg', 'active' => '1', 'name' => 'Mecánico Especialista'),
        array('id' => '152', 'nombre' => 'Edgar David Meza Rivera', 'email' => 'emeza@gptservices.com', 'phone' => '(+52) 55 2280 0751', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117471/fotos/152.png', 'active' => '1', 'name' => 'Soporte Técnico IT'),
        array('id' => '157', 'nombre' => 'Claudio Magdaleno Pérez Hernández', 'email' => 'cperez@gptservices.com', 'phone' => '(+52) 55 8531 7147', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690390682/fotos/157.jpg', 'active' => '1', 'name' => 'Trainee HT & LS'),
        array('id' => '158', 'nombre' => 'Yanet Rosario Colín Antonio', 'email' => 'yrcolina@gptservices.com', 'phone' => '(+52) 55 2283 7096', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117491/fotos/158.png', 'active' => '1', 'name' => 'Contador Sr'),
        array('id' => '166', 'nombre' => 'Rafael Alejandro Jiménez Ávila', 'email' => 'rajimeneza@gptservices.com', 'phone' => '(+52) 55 5953 0834', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117532/fotos/166.png', 'active' => '1', 'name' => 'Contador Sr'),
        array('id' => '168', 'nombre' => 'Sergio Antonio Ordaz Espinoza', 'email' => 'santonio@gptservices.com', 'phone' => '(+52) 55 5103 5335', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1691686850/fotos/168.png', 'active' => '1', 'name' => 'Gerencia de Contratos'),
        array('id' => '180', 'nombre' => 'Jorge Eduardo García Ojeda', 'email' => 'jegarciao@gptservices.com', 'phone' => '(+52) 55 30 40 90 54', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117581/fotos/180.png', 'active' => '1', 'name' => 'Jefatura de Compras'),
        array('id' => '187', 'nombre' => 'Alejandro Aldair Ramírez Pérez', 'email' => 'aramirezp@gptservices.com', 'phone' => '(+52) 55 83 59 05 08', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690912089/fotos/187.jpg', 'active' => '1', 'name' => 'Ingeniero de Costos Jr'),
        array('id' => '191', 'nombre' => 'Jennifer Martínez Jarquín', 'email' => 'jmartinezj@gptservices.com', 'phone' => '(+52) 55 74 99 89 47', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117629/fotos/191.png', 'active' => '1', 'name' => 'Diseñador'),
        array('id' => '193', 'nombre' => 'Martín Alejandro Martínez Hernández', 'email' => 'mmartinez@gptservices.com', 'phone' => '(+52) 56 19 43 95 09', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117672/fotos/193.png', 'active' => '1', 'name' => 'Servicios Generales Sr'),
        array('id' => '199', 'nombre' => 'Alan Etzahu Hernández Mendoza', 'email' => 'ahernandezm@gptservices.com', 'phone' => '(+52) 5540756374', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1695311792/fotos/199.png', 'active' => '1', 'name' => 'Trainee de IT'),
        array('id' => '200', 'nombre' => 'Rocío Rojas González', 'email' => 'rrojasg@gptservices.com', 'phone' => '(+52) 5591862465', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1691706348/fotos/200.png', 'active' => '1', 'name' => 'Ingeniero de Calidad Jr.'),
        array('id' => '202', 'nombre' => 'Daniel González García', 'email' => '', 'phone' => '(+52) 55 11 79 61 70', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117694/fotos/202.png', 'active' => '1', 'name' => 'Limpieza'),
        array('id' => '205', 'nombre' => 'Erik David López Olvera', 'email' => 'edlopezo@gptservices.com', 'phone' => '(+52) 55 81 29 09 74', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690390600/fotos/205.jpg', 'active' => '1', 'name' => 'Trainee HT & LS'),
        array('id' => '212', 'nombre' => 'Enrique Villafranca García', 'email' => 'evillafranca@gptservices.com', 'phone' => '(+52) 55 45 94 36 60', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690999117/fotos/212.jpg', 'active' => '1', 'name' => 'Trainee HT & LS'),
        array('id' => '223', 'nombre' => 'José Héctor Avilés Nieto', 'email' => 'haviles@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117793/fotos/223.png', 'active' => '1', 'name' => 'Servicios Generales Jr'),
        array('id' => '227', 'nombre' => 'Kevin Hazael Pérez Rodríguez', 'email' => 'kperez@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692117814/fotos/227.jpg', 'active' => '1', 'name' => 'Jefatura de Proyectos'),
        array('id' => '230', 'nombre' => 'Ernesto Bautista Cruz', 'email' => 'ebautista@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690911999/fotos/230.jpg', 'active' => '1', 'name' => 'Servicios Generales Jr'),
        array('id' => '233', 'nombre' => 'Israel Correa Cruz', 'email' => 'icorrea@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690911929/fotos/233.jpg', 'active' => '1', 'name' => 'Ingeniero de Contratos Gobierno'),
        array('id' => '235', 'nombre' => 'Giovanni Lugardo Aguilar', 'email' => '', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692118006/fotos/235.png', 'active' => '1', 'name' => 'Mecánico Tornero'),
        array('id' => '240', 'nombre' => 'Mónica Jazmín Pimentel García', 'email' => 'mpimentel@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1725902591/fotos/240.png', 'active' => '1', 'name' => 'Trainee de Marketing'),
        array('id' => '247', 'nombre' => 'Juan Carlos Prado Hernández', 'email' => 'jprado@gptservices.com', 'phone' => '(55)45570447', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1691422743/fotos/247.png', 'active' => '1', 'name' => 'Trainee de Contabilidad'),
        array('id' => '249', 'nombre' => 'Rocío Salgado Rangel', 'email' => 'rsalgado@gptservices.com', 'phone' => '(+52) 55 8404 3368', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1691706388/fotos/249.png', 'active' => '1', 'name' => 'Ayudante de manufactura'),
        array('id' => '250', 'nombre' => 'José Carlos Martínez Amador', 'email' => 'jmartinez@gptservices.com', 'phone' => '(+52) 56 2102 933', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692118109/fotos/250.png', 'active' => '1', 'name' => 'Encargado de Almacén'),
        array('id' => '251', 'nombre' => 'Alejandro Rodríguez Vázquez', 'email' => 'arodriguez@gptservices.com', 'phone' => '5544645133', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692118129/fotos/251.png', 'active' => '1', 'name' => 'Chofer'),
        array('id' => '252', 'nombre' => 'Israel Omar Mora Barrios', 'email' => 'imora@gptservices.com', 'phone' => '5586019168', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692118157/fotos/252.png', 'active' => '1', 'name' => 'Ayudante de Soldador'),
        array('id' => '253', 'nombre' => 'Daniel Nuñez Cruz', 'email' => '', 'phone' => '5613041196', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692118182/fotos/253.png', 'active' => '1', 'name' => 'Ayudante de Mantenimiento'),
        array('id' => '256', 'nombre' => 'Rosa Maria Mendoza Gutierrez', 'email' => '', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692118204/fotos/256.png', 'active' => '1', 'name' => 'Limpieza'),
        array('id' => '257', 'nombre' => 'Sergio Martín Ramírez Jaimes', 'email' => 'sramirez@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1691177963/fotos/257.jpg', 'active' => '1', 'name' => 'Maniobrista'),
        array('id' => '258', 'nombre' => 'Julia  Flores Valenzuela ', 'email' => '', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1693500601/fotos/258.png', 'active' => '1', 'name' => 'Limpieza'),
        array('id' => '260', 'nombre' => 'José de Jesús Lázaro Juárez', 'email' => 'jlazaro@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690395269/fotos/260.jpg', 'active' => '1', 'name' => 'Ingeniero de Producto'),
        array('id' => '263', 'nombre' => 'Elizabeth García Real Joya', 'email' => 'egarcia@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690386700/fotos/263.jpg', 'active' => '1', 'name' => 'Recursos Humanos Jr'),
        array('id' => '264', 'nombre' => 'Juan Carlos López Hernández', 'email' => 'jhernandez@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690386756/fotos/264.jpg', 'active' => '1', 'name' => 'Servicios Generales Jr'),
        array('id' => '265', 'nombre' => 'Alfonso  Gómez López ', 'email' => '', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690386819/fotos/265.jpg', 'active' => '1', 'name' => 'Pintor industrial'),
        array('id' => '266', 'nombre' => 'Omar Alvarado Bailey', 'email' => 'oalvarado@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690386883/fotos/266.jpg', 'active' => '1', 'name' => 'Ingeniero de Desarrollo (Mejora Continua)'),
        array('id' => '268', 'nombre' => 'Carlos Ivan Carbajal Cerezo', 'email' => '', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690386946/fotos/268.jpg', 'active' => '1', 'name' => 'Mecánico Especialista'),
        array('id' => '269', 'nombre' => 'Javier Mozart Santos Cruces', 'email' => 'jsantos@gptservices.com', 'phone' => '', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692115988/fotos/269.jpg', 'active' => '1', 'name' => 'Ingeniero de proyectos'),
        array('id' => '270', 'nombre' => 'Miguel Eduardo Orduña Álvarez', 'email' => 'eorduna@gptservices.com', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690389064/fotos/270.png', 'active' => '1', 'name' => 'Técnico Especialista en HT & LS Nivel II'),
        array('id' => '271', 'nombre' => 'José Manuel Cardona Salinas', 'email' => 'jcardona@gptservices.com', 'phone' => '5610040567', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1690389168/fotos/271.jpg', 'active' => '1', 'name' => 'Operador de Grúa'),
        array('id' => '274', 'nombre' => 'María Fernanda López Muñóz', 'email' => 'mlopez@gptservices.com', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692111512/fotos/274.png', 'active' => '1', 'name' => 'Comprador'),
        array('id' => '275', 'nombre' => 'Agustín Quechol Millán', 'email' => 'NA', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1694463391/fotos/275.png', 'active' => '1', 'name' => 'Mecánico Tornero'),
        array('id' => '276', 'nombre' => 'Leonardo Paredes Chávez', 'email' => 'lparedes@gptservices.com', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1694702406/fotos/276.jpg', 'active' => '1', 'name' => 'Ingeniero de Producto'),
        array('id' => '277', 'nombre' => 'Antonio  Guevara Galán ', 'email' => 'guevaraantonio376@gmail.com', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1695311280/fotos/277.jpg', 'active' => '1', 'name' => 'Guardia de seguridad'),
        array('id' => '282', 'nombre' => 'Diana Martínez Dolores', 'email' => 'dmartinez@gptservices.com', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1696962174/fotos/282.jpg', 'active' => '1', 'name' => 'Trainee de Contabilidad'),
        array('id' => '285', 'nombre' => 'Juan Gabriel Castañeda Martínez', 'email' => 'NA', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1704318005/fotos/285.jpg', 'active' => '1', 'name' => 'Guardia de seguridad'),
        array('id' => '286', 'nombre' => 'Luis Enrique Pardo Sánchez', 'email' => 'NA', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1705692775/fotos/286.jpg', 'active' => '1', 'name' => 'Mecánico Tornero'),
        array('id' => '287', 'nombre' => 'Eduardo Moreno Carmona', 'email' => 'emoreno@gptservices.com', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1705692816/fotos/287.jpg', 'active' => '1', 'name' => 'Ingeniero de Producto'),
        array('id' => '289', 'nombre' => 'Miguel Ángel Raya Espino', 'email' => 'NA', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1706109509/fotos/289.jpg', 'active' => '1', 'name' => 'Mecánico Tornero'),
        array('id' => '290', 'nombre' => 'Mariana Karina Jiménez Ortega', 'email' => 'mjimenez@gptservices.com', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1706811058/fotos/290.jpg', 'active' => '1', 'name' => 'Trainee de Contabilidad'),
        array('id' => '292', 'nombre' => 'Fernando Zamora González', 'email' => 'fzamora@gptservices.com', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1707416401/fotos/292.jpg', 'active' => '1', 'name' => 'Almacenista'),
        array('id' => '293', 'nombre' => 'Jatziri Yamile Alejo Osorio', 'email' => 'jalejo@gptservices.com', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1708365641/fotos/293.jpg', 'active' => '1', 'name' => 'Trainee de HSE'),
        array('id' => '296', 'nombre' => 'Paola Chávez Huerta', 'email' => 'pchavez@gptservices.com', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1711135809/fotos/296.jpg', 'active' => '1', 'name' => 'Recursos Humanos Jr'),
        array('id' => '298', 'nombre' => 'Ingrid Danae González Cisneros', 'email' => 'igonzalez@gptservices.com', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1713211874/fotos/298.jpg', 'active' => '1', 'name' => 'Comprador'),
        array('id' => '299', 'nombre' => 'Christian Alberto Gómez Matilde', 'email' => 'NA', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1714071483/fotos/299.jpg', 'active' => '1', 'name' => 'Técnico Soldador'),
        array('id' => '301', 'nombre' => 'Pablo Angel Vazquez Hernández', 'email' => 'pvazquez@gptservices.com', 'phone' => 'NA', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1707416065/fotos/12001.jpg', 'active' => '1', 'name' => 'Trainee de Sistema de Gestión Integral (SGI)'),
        array('id' => '302', 'nombre' => 'Monica Esthela Padilla Gónzalez', 'email' => 'mpadilla@gptservices.com', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1718040767/fotos/302.jpg', 'active' => '1', 'name' => 'Trainee de Recursos Humanos'),
        array('id' => '303', 'nombre' => 'Luis Adrián Sánchez González', 'email' => 'lsanchez@gptservices.com', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1720551561/fotos/303.jpg', 'active' => '1', 'name' => 'Ingeniero de Ventas'),
        array('id' => '304', 'nombre' => 'Francisco Alejandro Contreras García', 'email' => 'fcontreras@gptservices.com', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1720467861/fotos/304.jpg', 'active' => '1', 'name' => 'Jefatura de Ventas'),
        array('id' => '305', 'nombre' => 'María de los Ángeles Quintanar Pérez', 'email' => 'mquintanar@gptservices.com', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1722614803/fotos/305.jpg', 'active' => '1', 'name' => 'Comprador'),
        array('id' => '306', 'nombre' => 'Bruno Cruz Montes', 'email' => 'bcruz@gptservices.com', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1722520442/fotos/306.jpg', 'active' => '1', 'name' => 'Analista de administración y presupuestos'),
        array('id' => '307', 'nombre' => 'Francisco Luna García', 'email' => 'fluna@gptservices.com', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1724179736/fotos/307.jpg', 'active' => '1', 'name' => 'Almacenista'),
        array('id' => '309', 'nombre' => 'Fernando Butrón González', 'email' => 'fbutron@gptservices.com', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1725388145/fotos/309.jpg', 'active' => '1', 'name' => 'Inspector de control de calidad'),
        array('id' => '310', 'nombre' => 'Daniel Iriarte Pérez', 'email' => 'diriarte@gptservices.com', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1725904595/fotos/310.jpg', 'active' => '1', 'name' => 'Ingeniero de proyectos'),
        array('id' => '311', 'nombre' => 'Miguel Ángel Guerrero Cruz', 'email' => 'vigilanciagpt@gptservices.com', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1727975908/fotos/311.jpg', 'active' => '1', 'name' => 'Guardia de seguridad'),
        array('id' => '313', 'nombre' => 'María Guadalupe Osorio Rodríguez', 'email' => 'mosorio@gptservices.com', 'phone' => '5612941921', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1730144309/fotos/313.jpg', 'active' => '1', 'name' => 'Ingeniero de Ventas'),
        array('id' => '314', 'nombre' => 'Edgar Domínguez Espinosa', 'email' => 'edominguez@gptservices.com', 'phone' => '5612940661', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1730830846/fotos/314.jpg', 'active' => '1', 'name' => 'Residente de Obra (OMA)'),
        array('id' => '315', 'nombre' => 'Carlos Alonso Pérez', 'email' => 'calonso@gptservices.com', 'phone' => '(+1) 832 270 8700', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692118250/fotos/315.jpg', 'active' => '1', 'name' => 'Dirección General'),
        array('id' => '316', 'nombre' => 'Daniel Eduardo Serrano González', 'email' => 'dserrano@gptservices.com', 'phone' => NULL, 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1736276111/fotos/316.jpg', 'active' => '1', 'name' => 'Responsable del Sistema de Gestión Integral (SGI)'),
        array('id' => '331', 'nombre' => 'José Carmen Rodríguez Lara', 'email' => 'jrlara@gptservices.com', 'phone' => '(+52) 81 8473 8500', 'profile_image' => 'https://res.cloudinary.com/gpt-services/image/upload/v1692118265/fotos/331.png', 'active' => '1', 'name' => 'Gerencia de servicios generales y almacén')
    );
    //   return $users;
    try {
        DB::beginTransaction();
        foreach ($users as $user) {
            User::create([
                'id' => $user['id'],
                'name' => $user['nombre'],
                'puesto' => $user['name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'active' => $user['active'],
            ]);
        }
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        throw new \Exception($e->getMessage());
    }
});

Route::get('cadenas-migrar', function () {
    $collection = fastexcel()->import('cadenas.xlsx');
    $users = User::all();
    // $collection = $collection->pluck('Revisa')->unique();

    // foreach($collection as $item) {
    //     $result= $users->where('name',$item)->first();
    //     echo '<br>';
    //     echo 'ITEM:'.$item;
    //     echo '<br>';
    //     echo 'DB:'. filled($result) ? $result?->id : 'VACIO';
    //     echo '<br>';

    // }
    try {
        DB::beginTransaction();
        foreach ($collection as $item) {
            $solicita = $users->where('name', $item['Solicita'])->first();
            $revisa = $users->where('name', $item['Revisa'])->first();
            $autoriza = $users->where('name', $item['Aprueba'])->first();
            $record = PurchaseRequisitionApprovalChain::create([
                'requester_id' => $solicita->id,
                'reviewer_id' => $revisa->id,
                'approver_id' => $autoriza->id,
                'authorizer_id' => $item['Autoriza'],
            ]);
            $record->requester->assignRole('solicita_requisicion_compra');
            $record->reviewer->assignRole('revisa_requisicion_compra');
            $record->approver->assignRole('aprueba_requisicion_compra');
        }
        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        throw ($e);
    }
});

Route::get('correos', function () {
    $users = array(
        array('id' => '13', 'name' => 'Benjamín Alcántara Bautista', 'email' => 'balcantarab@gptservices.com'),
        array('id' => '14', 'name' => 'Jesús Becerra Yebra', 'email' => 'jbecerray@gptservices.com'),
        array('id' => '18', 'name' => 'Ana Lilia López Arreola', 'email' => 'alopeza@gptservices.com'),
        array('id' => '19', 'name' => 'Rafael García Arroyo', 'email' => 'rgarciaa@gptservices.com'),
        array('id' => '22', 'name' => 'Iván Ponce Reyes', 'email' => 'iponcer@gptservices.com'),
        array('id' => '26', 'name' => 'Sinhue Ulloa Tello', 'email' => 'sulloat@gptservices.com'),
        array('id' => '36', 'name' => 'Guillermo Gutiérrez Melo', 'email' => 'ggutierrezm@gptservices.com'),
        array('id' => '37', 'name' => 'Luis Reyes Yáñez', 'email' => 'lreyesy@gptservices.com'),
        array('id' => '40', 'name' => 'Fernando Basave Arce', 'email' => 'febasavea@gptservices.com'),
        array('id' => '46', 'name' => 'Aquiles Gonzalo García Montiel', 'email' => 'agarciam@gptservices.com'),
        array('id' => '50', 'name' => 'Aurelio Cruz Báez', 'email' => 'acruzb@gptservices.com'),
        array('id' => '53', 'name' => 'Adriana González Huitrón', 'email' => 'agonzalezh@gptservices.com'),
        array('id' => '64', 'name' => 'Luis Sandoval Cabello', 'email' => 'lsandovalc@gptservices.com'),
        array('id' => '89', 'name' => 'Juan Jiménez Camacho', 'email' => 'jjimenezc@gptservices.com'),
        array('id' => '92', 'name' => 'Néstor Adair Acosta Arroyo', 'email' => 'naacostaa@gptservices.com'),
        array('id' => '99', 'name' => 'Raúl Rodríguez Guzmán', 'email' => 'rrodriguezg@gptservices.com'),
        array('id' => '106', 'name' => 'Denise Marisol Reyes Ramírez', 'email' => 'dmreyesr@gptservices.com'),
        array('id' => '114', 'name' => 'Manuel Antonio Ríos Cuautitla', 'email' => 'mariosc@gptservices.com'),
        array('id' => '120', 'name' => 'Roberto González Muñoz', 'email' => 'rgonzalezm@gptservices.com'),
        array('id' => '123', 'name' => 'Angélica Salgado Zúñiga', 'email' => 'asalgadoz@gptservices.com'),
        array('id' => '131', 'name' => 'Axel Javier Martínez Segura', 'email' => 'ajmartinezs@gptservices.com'),
        array('id' => '132', 'name' => 'Martín Paes Santillán', 'email' => 'mpaess@gptservices.com'),
        array('id' => '137', 'name' => 'Luis Jesús Godínez Rivera', 'email' => 'lgodinez@gptservices.com'),
        array('id' => '152', 'name' => 'Edgar David Meza Rivera', 'email' => 'emeza@gptservices.com'),
        array('id' => '157', 'name' => 'Claudio Magdaleno Pérez Hernández', 'email' => 'cperez@gptservices.com'),
        array('id' => '158', 'name' => 'Yanet Rosario Colín Antonio', 'email' => 'yrcolina@gptservices.com'),
        array('id' => '166', 'name' => 'Rafael Alejandro Jiménez Ávila', 'email' => 'rajimeneza@gptservices.com'),
        array('id' => '168', 'name' => 'Sergio Antonio Ordaz Espinoza', 'email' => 'santonio@gptservices.com'),
        array('id' => '180', 'name' => 'Jorge Eduardo García Ojeda', 'email' => 'jegarciao@gptservices.com'),
        array('id' => '187', 'name' => 'Alejandro Aldair Ramírez Pérez', 'email' => 'aramirezp@gptservices.com'),
        array('id' => '191', 'name' => 'Jennifer Martínez Jarquín', 'email' => 'jmartinezj@gptservices.com'),
        array('id' => '193', 'name' => 'Martín Alejandro Martínez Hernández', 'email' => 'mmartinez@gptservices.com'),
        array('id' => '199', 'name' => 'Alan Etzahu Hernández Mendoza', 'email' => 'ahernandezm@gptservices.com'),
        array('id' => '200', 'name' => 'Rocío Rojas González', 'email' => 'rrojasg@gptservices.com'),
        array('id' => '205', 'name' => 'Erik David López Olvera', 'email' => 'edlopezo@gptservices.com'),
        array('id' => '212', 'name' => 'Enrique Villafranca García', 'email' => 'evillafranca@gptservices.com'),
        array('id' => '223', 'name' => 'José Héctor Avilés Nieto', 'email' => 'haviles@gptservices.com'),
        array('id' => '227', 'name' => 'Kevin Hazael Pérez Rodríguez', 'email' => 'kperez@gptservices.com'),
        array('id' => '230', 'name' => 'Ernesto Bautista Cruz', 'email' => 'ebautista@gptservices.com'),
        array('id' => '233', 'name' => 'Israel Correa Cruz', 'email' => 'icorrea@gptservices.com'),
        array('id' => '240', 'name' => 'Mónica Jazmín Pimentel García', 'email' => 'mpimentel@gptservices.com'),
        array('id' => '247', 'name' => 'Juan Carlos Prado Hernández', 'email' => 'jprado@gptservices.com'),
        array('id' => '249', 'name' => 'Rocío Salgado Rangel', 'email' => 'rsalgado@gptservices.com'),
        array('id' => '250', 'name' => 'José Carlos Martínez Amador', 'email' => 'jmartinez@gptservices.com'),
        array('id' => '251', 'name' => 'Alejandro Rodríguez Vázquez', 'email' => 'arodriguez@gptservices.com'),
        array('id' => '252', 'name' => 'Israel Omar Mora Barrios', 'email' => 'imora@gptservices.com'),
        array('id' => '257', 'name' => 'Sergio Martín Ramírez Jaimes', 'email' => 'sramirez@gptservices.com'),
        array('id' => '260', 'name' => 'José de Jesús Lázaro Juárez', 'email' => 'jlazaro@gptservices.com'),
        array('id' => '263', 'name' => 'Elizabeth García Real Joya', 'email' => 'egarcia@gptservices.com'),
        array('id' => '264', 'name' => 'Juan Carlos López Hernández', 'email' => 'jhernandez@gptservices.com'),
        array('id' => '266', 'name' => 'Omar Alvarado Bailey', 'email' => 'oalvarado@gptservices.com'),
        array('id' => '269', 'name' => 'Javier Mozart Santos Cruces', 'email' => 'jsantos@gptservices.com'),
        array('id' => '270', 'name' => 'Miguel Eduardo Orduña Álvarez', 'email' => 'eorduna@gptservices.com'),
        array('id' => '271', 'name' => 'José Manuel Cardona Salinas', 'email' => 'jcardona@gptservices.com'),
        array('id' => '274', 'name' => 'María Fernanda López Muñóz', 'email' => 'mlopez@gptservices.com'),
        array('id' => '276', 'name' => 'Leonardo Paredes Chávez', 'email' => 'lparedes@gptservices.com'),
        array('id' => '277', 'name' => 'Antonio  Guevara Galán ', 'email' => 'guevaraantonio376@gmail.com'),
        array('id' => '282', 'name' => 'Diana Martínez Dolores', 'email' => 'dmartinez@gptservices.com'),
        array('id' => '287', 'name' => 'Eduardo Moreno Carmona', 'email' => 'emoreno@gptservices.com'),
        array('id' => '290', 'name' => 'Mariana Karina Jiménez Ortega', 'email' => 'mjimenez@gptservices.com'),
        array('id' => '292', 'name' => 'Fernando Zamora González', 'email' => 'fzamora@gptservices.com'),
        array('id' => '293', 'name' => 'Jatziri Yamile Alejo Osorio', 'email' => 'jalejo@gptservices.com'),
        array('id' => '296', 'name' => 'Paola Chávez Huerta', 'email' => 'pchavez@gptservices.com'),
        array('id' => '298', 'name' => 'Ingrid Danae González Cisneros', 'email' => 'igonzalez@gptservices.com'),
        array('id' => '301', 'name' => 'Pablo Angel Vazquez Hernández', 'email' => 'pvazquez@gptservices.com'),
        array('id' => '302', 'name' => 'Monica Esthela Padilla Gónzalez', 'email' => 'mpadilla@gptservices.com'),
        array('id' => '303', 'name' => 'Luis Adrián Sánchez González', 'email' => 'lsanchez@gptservices.com'),
        array('id' => '304', 'name' => 'Francisco Alejandro Contreras García', 'email' => 'fcontreras@gptservices.com'),
        array('id' => '305', 'name' => 'María de los Ángeles Quintanar Pérez', 'email' => 'mquintanar@gptservices.com'),
        array('id' => '306', 'name' => 'Bruno Cruz Montes', 'email' => 'bcruz@gptservices.com'),
        array('id' => '307', 'name' => 'Francisco Luna García', 'email' => 'fluna@gptservices.com'),
        array('id' => '309', 'name' => 'Fernando Butrón González', 'email' => 'fbutron@gptservices.com'),
        array('id' => '310', 'name' => 'Daniel Iriarte Pérez', 'email' => 'diriarte@gptservices.com'),
        array('id' => '311', 'name' => 'Miguel Ángel Guerrero Cruz', 'email' => 'vigilanciagpt@gptservices.com'),
        array('id' => '313', 'name' => 'María Guadalupe Osorio Rodríguez', 'email' => 'mosorio@gptservices.com'),
        array('id' => '314', 'name' => 'Edgar Domínguez Espinosa', 'email' => 'edominguez@gptservices.com'),
        array('id' => '316', 'name' => 'Daniel Eduardo Serrano González', 'email' => 'dserrano@gptservices.com'),
        array('id' => '331', 'name' => 'José Carmen Rodríguez Lara', 'email' => 'jrlara@gptservices.com')
    );
    $users = collect($users);
    $correos = $users->pluck('email')->values()->all();

    $correosEncuesta = [
        'haviles@gptservices.com',
        'lsanchez@gptservices.com',
        'iponcer@gptservices.com',
        'bcruz@gptservices.com',
        'jegarciao@gptservices.com',
        'asalgadoz@gptservices.com',
        'mquintanar@gptservices.com',
        'mpimentel@gptservices.com',
        'pchavez@gptservices.com',
        'mlopez@gptservices.com',
        'mpadilla@gptservices.com',
        'lgodinez@gptservices.com',
        'diriarte@gptservices.com',
        'alopeza@gptservices.com',
        'diriarte@gptservices.com',
        'oalvarado@gptservices.com',
        'mariosc@gptservices.com',
        'naacostaa@gptservices.com',
        'fluna@gptservices.com',
        'arodriguez@gptservices.com',
        'fzamora@gptservices.com',
        'sramirez@gptservices.com',
        'agonzalezh@gptservices.com',
        'pvazquez@gptservices.com',
        'vigilanciagpt@gptservices.com',
        'acruzb@gptservices.com',
        'evillafranca@gptservices.com',
        'ahernandezm@gptservices.com',
        'ggutierrezm@gptservices.com',
        'igonzalez@gptservices.com',
        'fbutron@gptservices.com',
        'jrlara@gptservices.com',
        'mjimenez@gptservices.com',
        'emeza@gptservices.com',
        'rajimeneza@gptservices.com',
        'dmartinez@gptservices.com',
        'jbecerray@gptservices.com',
        'cperez@gptservices.com',
        'rrodriguezg@gptservices.com',
        'eorduna@gptservices.com',
        'jsantos@gptservices.com',
        'yrcolina@gptservices.com',
        'edlopezo@gptservices.com',
        'jcardona@gptservices.com',
        'eorduna@gptservices.com',
        'jhernandez@gptservices.com',
        'cgomez@gptservices.com',
        'rgarciaa@gptservices.com',
        'jprado@gptservices.com',
        'jprado@gptservices.com',
        'febasavea@gptservices.com',
        'mmartinez@gptservices.com',
        'jjimenezc@gptservices.com',
        'lparedes@gptservices.com',
        'rrojasg@gptservices.com',
        'sulloat@gptservices.com',
        'rsalgado@gptservices.com',
        'ajmartinezs@gptservices.com',
        'imora@gptservices.com',
        'mpaess@gptservices.com',
        'egarcia@gptservices.com',
        'dmreyesr@gptservices.com',
        'jalejo@gptservices.com',
        'lreyesy@gptservices.com',
        'dserrano@gptservices.com',
        'jlazaro@gptservices.com',
    ];
    $diff = array_diff($correos, $correosEncuesta);

    $usersFaltantes = [];
    foreach ($diff as $item) {
        $falta = $users->where('email', $item)->first();
        $usersFaltantes[] = $falta;
    }
    return fastexcel($usersFaltantes)->download('file.xlsx');
    return $usersFaltantes;
    return $diff;
});

Route::get('sin-correo', function () {
    $users = array(
        array('id' => '202', 'nombre' => 'Daniel González García', 'email' => ''),
        array('id' => '235', 'nombre' => 'Giovanni Lugardo Aguilar', 'email' => ''),
        array('id' => '253', 'nombre' => 'Daniel Nuñez Cruz', 'email' => ''),
        array('id' => '256', 'nombre' => 'Rosa Maria Mendoza Gutierrez', 'email' => ''),
        array('id' => '258', 'nombre' => 'Julia  Flores Valenzuela ', 'email' => ''),
        array('id' => '265', 'nombre' => 'Alfonso  Gómez López ', 'email' => ''),
        array('id' => '268', 'nombre' => 'Carlos Ivan Carbajal Cerezo', 'email' => ''),
        array('id' => '275', 'nombre' => 'Agustín Quechol Millán', 'email' => NULL),
        array('id' => '277', 'nombre' => 'Antonio  Guevara Galán ', 'email' => NULL),
        array('id' => '285', 'nombre' => 'Juan Gabriel Castañeda Martínez', 'email' => 'NA'),
        array('id' => '286', 'nombre' => 'Luis Enrique Pardo Sánchez', 'email' => 'NA'),
        array('id' => '289', 'nombre' => 'Miguel Ángel Raya Espino', 'email' => 'NA'),
        array('id' => '299', 'nombre' => 'Christian Alberto Gómez Matilde', 'email' => 'NA'),
    );
    return fastexcel($users)->download('file.xlsx');
});

Route::get('encuestas-migrate', function () {
    $tickets_it = array(
        array('folio' => 'TI2024-001', 'calificacion_servicio' => '0'),
        array('folio' => 'TI2024-002', 'calificacion_servicio' => '0'),
        array('folio' => 'TI2024-003', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-004', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-005', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-006', 'calificacion_servicio' => '0'),
        array('folio' => 'TI2024-010', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-011', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-013', 'calificacion_servicio' => '3'),
        array('folio' => 'TI2024-014', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-015', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-016', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-017', 'calificacion_servicio' => '4'),
        array('folio' => 'TI2024-018', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-019', 'calificacion_servicio' => '3'),
        array('folio' => 'TI2024-021', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-022', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-024', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-025', 'calificacion_servicio' => '1'),
        array('folio' => 'TI2024-026', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-028', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-029', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-030', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-032', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-033', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-034', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-037', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-039', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-042', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-043', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-046', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-048', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-049', 'calificacion_servicio' => '4'),
        array('folio' => 'TI2024-050', 'calificacion_servicio' => '4'),
        array('folio' => 'TI2024-053', 'calificacion_servicio' => '1'),
        array('folio' => 'TI2024-056', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-057', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-060', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-064', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-065', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-066', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-067', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-068', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-071', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-072', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-076', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-077', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-078', 'calificacion_servicio' => '5'),
        array('folio' => 'TI2024-079', 'calificacion_servicio' => '5')
    );

    return fastexcel($tickets_it)->download('tickets_it.xlsx');
});
Route::get('concentrado', function () {
    // $category = [];
    $array = [];
    $unidades = MeasureUnit::get();
    $categorias = Category::with('families')->get();
    $collection = fastexcel()->import('productos.xlsx');
    $collection = $collection->groupBy('CAT');
    try {
        DB::beginTransaction();
        foreach ($collection as $key => $item) {
            $category = $categorias->where('code', $key)->first();
            $familias = $category->families;
            foreach ($item as $product) {
                $unidad = $unidades->where('acronym', $product['unidad'])->first();
                $familia = $familias->where('code', $product['FAM'])->first();
                echo '<br>';
                echo $category->code;
                echo '<br>';
                echo blank($familia) ? 'NO' : $familia->code;
                echo '<br>';
                echo $product['FAM'];
                echo '<br>';
                $array[] = [
                    'name' => $product['DESCRIPCIÓN'],
                    'code' => $product['CÓDIGO'],
                    'category_id' => $category->id,
                    'category_family_id' => $familia->id,
                    'unit_id' => $unidad->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        DB::table('products')->insert($array);
        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }
});
Route::get('cat', function () {
    $collection = fastexcel()->import('clasificacion.xlsx');
    $categorias = Category::all();
    $categoria = $categorias->where('code', $collection[0]['cat'])->first();
    try {
        DB::beginTransaction();
        foreach ($collection as $item) {
            CategoryFamily::updateOrCreate(
                [
                    'code' => $item['fam'],
                    'category_id' => $categoria->id,
                ],
                [
                    'name' => $item['des'],
                    'code' => $item['fam'],
                    'type' => 'Stock',
                    'category_id' => $categoria->id,
                ]
            );
        }
        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }
    // return $collection;
});

Route::get('test',function(){
    $data = Product::all();
    try{
        DB::beginTransaction();
        foreach ($data as $key => $product) {
            $product->id = $key +1;
            $product->save();
        }
        DB::commit();
    }catch(Exception $e){
        DB::rollBack();
        throw $e;
    }
});
