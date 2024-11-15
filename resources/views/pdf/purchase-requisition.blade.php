<!doctype html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Requisición</title>
    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        @page {
            margin: 80px 25px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        h4 {
            margin: 0;
        }

        .w-full {
            width: 100%;
        }

        .general {
            font-size: 12px;
        }

        .general p {
            margin: 0;
            padding: 3px 5px;
        }

        .w-half {
            width: 50%;
        }

        .margin-top {
            margin-top: 1.25rem;
        }

        table {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            border: 1px solid #252F34;
        }

        td {
            border: 1px solid #252F34;
            padding: 0;
        }
    </style>
</head>

<body>
    {{-- cabecera --}}
    <header>
        <table class="w-full">
            <tr>
                <td rowspan="4" align="center" valing="middle">
                    {{-- row-1-1 --}}
                    <img src="{{ asset('images/logo/logotipo_GPT.png') }}" alt="logo" width="150px" />
                </td>
                <td colspan="4">
                    @if ($rq->company->acronym == 'T')
                        <p style="font-size:12px; padding:4px;margin:0;text-align:center;font-weight:bold;">TECH ENERGY
                            CONTROL
                        </p>
                    @elseif ($rq->company->acronym == 'G')
                        <p style="font-size:12px; padding:4px;margin:0;text-align:center;font-weight:bold;">GPT ING &
                            MANF
                        </p>
                    @endif
                </td>
                <td>
                    <p style="font-size:10px; padding:1px;margin:0;">Tipo de documento</p>
                </td>
                <td>
                    <p style="font-size:10px; padding:1px;margin:0;text-align:right;">Formato</p>
                </td>
                <td rowspan="4" align="center" valing="middle">
                    {{-- row-1-8 --}}
                    @if ($rq->company->acronym == 'T')
                        <img src="{{ asset('images/logo/companies/T.png') }}" alt="logo" width="150px" />
                    @elseif ($rq->company->acronym == 'G')
                        <img src="{{ asset('images/logo/companies/G.jpg') }}" alt="logo" width="150px" />
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="4" rowspan="3">
                    <p
                        style="font-size:12px; padding:1px;margin:0;text-align:center;text-transform:uppercase;font-weight:bold;">
                        Requisición
                        de compra</p>
                </td>
                <td>
                    <p style="font-size:10px; padding:1px;margin:0;">Revisión</p>
                </td>
                <td>
                    <p style="font-size:10px; padding:1px;margin:0;text-align:right;">03</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size:10px; padding:1px;margin:0;">Fecha de aprobación</p>
                </td>
                <td>
                    <p style="font-size:10px; padding:1px;margin:0;text-align:right;">dic-22</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size:10px; padding:1px;margin:0;">Código</p>
                </td>
                <td>
                    <p style="font-size:10px; padding:1px;margin:0;text-align:right;">FO-GPT-COM-01-A</p>
                </td>
            </tr>
        </table>
    </header>
    <br>
    {{-- Datos de la requisición --}}
    <table class="w-full general">
        <tbody>
            <tr>
                <td align="right"><strong>
                        <p>Número de requisición:</p>
                    </strong></td>
                <td>
                    <p>{{ $rq->folio }}</p>
                </td>
                <td rowspan="2">
                    <strong>
                        <p>Fecha de recepción por parte de procura</p>
                    </strong>
                </td>
                <td rowspan="2">
                    <p>Sin asignar</p>
                </td>
            </tr>
            <tr>
                <td align="right"><strong>
                        <p>Área o departamento:</p>
                    </strong></td>
                <td style="text-transform: uppercase">
                    <p>{{ $rq->approvalChain->requester->management->name }}</p>
                </td>
            </tr>
            <tr>
                <td align="right"><strong>
                        <p>Solicitante:</p>
                    </strong></td>
                <td style="text-transform: uppercase">
                    <p>{{ $rq->approvalChain->requester->name }}</p>
                </td>
                <td rowspan="2"><strong>
                        <p>Fecha deseable de entrega</p>
                    </strong></td>
                <td rowspan="2">
                    <p>{{ $rq->date_delivery->format('d-m-Y') }}</p>
                </td>
            </tr>
            <tr>
                <td align="right"><strong>
                        <p>Proyecto/Consumible/Activo fijo:</p>
                    </strong></td>
                <td>
                    <p>{{ $rq->project->code }} {{ $rq->project->name }}</p>
                </td>
            </tr>
            <tr>
                <td align="right"><strong>
                        <p>Domicilio de entrega:</p>
                    </strong></td>
                <td colspan="3">
                    <p>{{ $rq->delivery_address }}</p>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    {{-- Partidas --}}
    <table class="general">
        <thead>
            <tr>
                <th>
                    <p>Item</p>
                </th>
                <th>
                    <p>Producto/Servicio</p>
                </th>
                <th>
                    <p>Cantidad</p>
                </th>
                <th>
                    <p>UM</p>
                </th>
                <th>
                    <p>Descripción detallada</p>
                </th>
            </tr>
        </thead>
        <tbody>
            @if (filled($rq->items))
                @foreach ($rq->items as $item)
                    <tr>
                        <td style="padding:3px 5px;">{{ $loop->iteration }}</td>
                        <td style="padding:3px 5px;">{{ $item->product->name }}</td>
                        <td style="padding:3px 5px;">{{ $item->quantity_requested }}</td>
                        <td style="padding:3px 5px;">{{ $item->product->unit->name }}</td>
                        <td style="padding:3px 5px;">{{ $item->observation }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="padding:3px 5px;">Sin partidas</td>
                </tr>
            @endif
        </tbody>
    </table>
    <br>
    {{-- Observaciones --}}
    <table class="general">
        <thead>
            <tr>
                <th>
                    <p>Observaciones</p>
                </th>
            </tr>
        </thead>
        <tbody>
            @if (filled($rq->observations))
                <tr>
                    <td style="padding:3px 5px;">{{ $rq->observations }}</td>
                </tr>
            @else
                <tr>
                    <td style="padding:3px 5px;">Sin observaciones</td>
                </tr>
            @endif
        </tbody>
    </table>
    <br>
    {{-- fichas tecnicas --}}
    <table class="general">
        <thead>
            <tr>
                <th>
                    <p style="text-align: left;">Fichas técnicas</p>
                </th>
            </tr>
        </thead>
        <tbody>
            @if (filled($rq->getMedia('technical_data_sheets')))
                @foreach ($rq->getMedia('technical_data_sheets') as $file)
                    <tr>
                        <td style="padding:5px 7px;">
                            <a href="{{ $file->getUrl() }}" target="_blank" style="text-decoration: none;">
                                {{ $file->name }} ({{ $file->extension }})
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td style="padding:3px 5px;">Sin fichas técnicas</td>
                </tr>
            @endif
        </tbody>
    </table>
    <br>
    {{-- soportes --}}
    <table class="general">
        <thead>
            <tr>
                <th>
                    <p style="text-align: left;">Soportes</p>
                </th>
            </tr>
        </thead>
        <tbody>
            @if (filled($rq->getMedia('supports')))
                @foreach ($rq->getMedia('supports') as $file)
                    <tr>
                        <td style="padding:5px 7px;">
                            <a href="{{ $file->getUrl() }}" target="_blank" style="text-decoration: none;">
                                {{ $file->name }} ({{ $file->extension }})
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td style="padding:3px 5px;">Sin soportes</td>
                </tr>
            @endif
        </tbody>
    </table>
    <br>
    {{-- Firmas --}}
    <div>
        <table style="w-full">
            <tbody>
                <tr>
                    <td>
                        <table>
                            <thead>
                                <tr>
                                    <td>
                                        <p
                                            style="text-transform: uppercase;text-align: center;margin: 0;padding: 5px; font-weight: bold;font-size: 12px;">
                                            Visto bueno de almacén</p>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div style="height: 80px;"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p
                                            style="text-align: center;margin: 0;padding: 5px; font-weight: bold;font-size: 12px;">
                                            Usuario almacén</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table>
                            <thead>
                                <tr>
                                    <td>
                                        <p
                                            style="text-transform: uppercase;text-align: center;margin: 0;padding: 5px; font-weight: bold;font-size: 12px;">
                                            Solicita</p>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div style="height: 80px;"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p
                                            style="text-align: center;margin: 0;padding: 5px; font-weight: bold;font-size: 12px;">
                                            {{ $rq->approvalChain->requester->name }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table>
                            <thead>
                                <tr>
                                    <td>
                                        <p
                                            style="text-transform: uppercase;text-align: center;margin: 0;padding: 5px; font-weight: bold;font-size: 12px;">
                                            Autoriza</p>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div style="height: 80px;"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p
                                            style=" text-align: center;margin: 0;padding: 5px; font-weight: bold;font-size: 12px;">
                                            {{ $rq->approvalChain->approver->name }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <footer>
        <img src="{{ asset('images/watermark.jpg') }}" alt="watermark" style="height: 50px;">
    </footer>
</body>

</html>
