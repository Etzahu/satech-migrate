<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Orden de compra</title>
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
    <!--<![endif]-->
</head>

<body style="background-color: #cc2647;">
    <table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #cc2647;">
        <tbody>
            <tr><!--[if mso]>
 <td></td> <![endif]-->
                <td class="body-content" style="color: #343a40;font-family: Roboto, sans-serif;">
                    <table class="spacer" role="presentation" border="0" cellpadding="0" cellspacing="0"
                        style="width: 100%;height: 30px;">
                        <tbody>
                            <tr>
                                <td width="100%" height="30"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="container" width="100%" border="0" cellpadding="0" cellspacing="0"
                        role="presentation" style="max-width: 680px;margin: 0 auto;">
                        <tbody>
                            <tr>
                                <td class="container-content"
                                    style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
                                    <center>
                                        <!--[if mso]><img class="img-fluid" src="{{ asset('images/watermark.jpg') }}" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
                                            class="img-fluid" src="{{ asset('images/watermark.jpg') }}"
                                            style="width: 174px;"><!--<![endif]-->
                                        <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="20"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="btn btn-success btn-md btn-rounded" border="0"
                                        cellpadding="0" cellspacing="0" role="presentation" style="text-align: center;width: 200px; background-color:#cc2647;border-radius: 6px;">
                                        <tbody>
                                            <tr>
                                                <td class="btn-content" style=" padding: 10px 20px; border: none;cursor: pointer;vertical-align: middle;font-weight: 800;"><a href="https://app.gptsatech.com" style="color: #fff;text-decoration: none;">VER</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <h1
                                            style="background-color: #ffffff;font-size: 18px;font-family: Roboto, sans-serif;color: #162d4d;text-transform: uppercase;">
                                            Orden de compra</h1>

                                        <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="20"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-borderless" border="0" cellpadding="0"
                                            cellspacing="0">
                                            <thead>
                                                <tr></tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding:4px;width: 48.906px;"
                                                        width="48.906">Compañía</td>
                                                    <td
                                                        style="font-size: 12px;font-family: 'Roboto';padding:4px;text-align: left;font-weight: bold;color: #343a40;">
                                                        {{ $data['company']['name'] }}</td>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding:4px;width: 110.062px;"
                                                        width="110.062">No. de orden de compra</td>
                                                    <td
                                                        style="font-size: 12px;font-family: 'Roboto';padding:4px;font-weight: bold;color: #343a40;">
                                                        {{ $data['folio'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding:4px;">Proveedor</td>
                                                    <td
                                                        style="font-size: 12px;font-family: 'Roboto';padding:4px;text-align: left;font-weight: bold;color: #343a40;">
                                                        {{ $data['provider']['company_name'] }}</td>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding:4px;">Requisición
                                                    </td>
                                                    <td
                                                        style="font-size: 12px;font-family: 'Roboto';padding:4px;font-weight: bold;color: #343a40;">
                                                        {{ $data['requisition']['folio'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding:4px;">Comprador</td>
                                                    <td
                                                        style="font-size: 12px;font-family: 'Roboto';padding:4px;text-align: left;font-weight: bold;color: #343a40;">
                                                        {{ $data['purchaser']['name'] }}
                                                    </td>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding:4px;">Moneda</td>
                                                    <td
                                                        style="font-size: 12px;font-family: 'Roboto';padding:4px;text-align: left;font-weight: bold;color: #343a40;">
                                                        {{ $data['currency'] }}
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr></tr>
                                            </tbody>
                                        </table>

                                        @if ($data['itemsFormatted'])
                                            <table class="table table-bordered" border="0" cellpadding="0"
                                                cellspacing="0" style="border-radius: 6px;border-collapse: collapse;width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7"
                                                            style="color: #162d4d;font-weight: bold;font-size: 14px;border: 1px solid #6c6c6c;padding:4px;">
                                                            PARTIDAS</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center"
                                                            style="border: 1px solid #6c6c6c;padding:4px;font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: #343a40;width: 27.609px;"
                                                            width="27.609">Código</td>
                                                        <td class="text-center"
                                                            style="border: 1px solid #6c6c6c;padding:4px;font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: #343a40;">
                                                            Producto/Servicio</td>
                                                        <td class="text-center"
                                                            style="border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;color: #343a40;font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
                                                            width="74.406">Marca</td>
                                                        <td class="text-center"
                                                            style="border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;color: #343a40;font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
                                                            width="74.406">Unidad</td>
                                                        <td class="text-center"
                                                            style="border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;color: #343a40;font-size: 12px;font-weight: bold;width: 56.047px;"
                                                            width="56.047">Cantidad</td>
                                                        <td class="text-center"
                                                            style="border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;color: #343a40;font-size: 12px;font-weight: bold;width: 56.047px;"
                                                            width="56.047">P.U</td>
                                                        <td class="text-center"
                                                            style="border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;color: #343a40;font-size: 12px;font-weight: bold;width: 56.047px;"
                                                            width="56.047">Importe</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['itemsFormatted'] as $item)
                                                        <tr>
                                                            <td
                                                                style="border: 1px solid #6c6c6c;padding:4px;font-size: 12px;font-family: Roboto, sans-serif;">
                                                                {{ $item['code'] }}</td>
                                                            <td
                                                                style="border: 1px solid #6c6c6c;padding:4px;font-size: 12px;font-family: Roboto, sans-serif;">
                                                                {{ $item['name'] }}</td>
                                                            <td
                                                                style="border: 1px solid #6c6c6c;padding:4px;font-size: 12px;font-family: Roboto, sans-serif;">
                                                                {{ $item['brand'] }}</td>
                                                            <td
                                                                style="border: 1px solid #6c6c6c;padding:4px;font-size: 12px;font-family: Roboto, sans-serif;">
                                                                {{ $item['unit'] }}</td>
                                                            <td
                                                                style="border: 1px solid #6c6c6c;padding:4px;font-size: 12px;font-family: Roboto, sans-serif;">
                                                                {{ $item['quantity'] }}</td>
                                                            <td
                                                                style="border: 1px solid #6c6c6c;padding:4px;font-size: 12px;font-family: Roboto, sans-serif;">
                                                                {{ $item['unit_price'] }}</td>
                                                            <td
                                                                style="border: 1px solid #6c6c6c;padding:4px;font-size: 12px;font-family: Roboto, sans-serif;">
                                                                {{ $item['sub_total'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered" border="0" cellpadding="0"
                                                cellspacing="0" style="border-radius: 6px;border-collapse: collapse;width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2"
                                                            style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;border: 1px solid #6c6c6c;padding:4px;">
                                                            Observaciones de las partidas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['itemsFormatted'] as $item)
                                                        <tr>
                                                            <td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: #343a40;border: 1px solid #6c6c6c;padding:4px;"
                                                                width="68.547">Partida {{ $loop->iteration }}</td>
                                                            <td
                                                                style="font-size: 12px;font-family: Roboto, sans-serif;border: 1px solid #6c6c6c;padding:4px;">
                                                                {{ $item['observation'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                        <table class="table table-bordered" border="0" cellpadding="0"
                                            cellspacing="0" style="border-radius: 6px;width: 100%;border: 1px solid #6c6c6c;padding:4px;border-collapse: collapse;">
                                            <thead>
                                                <tr>
                                                    <th colspan="2"
                                                        style="color: #162d4d;font-weight: bold;font-size: 14px;border: 1px solid #6c6c6c;padding:4px;">
                                                        OBSERVACIONES O NOTAS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="font-family: Roboto, sans-serif;color: #5b6c82;">
                                                        <p class="text-justify" style="font-size: 12px;">
                                                            {{ $data['observations'] }}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 30px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="30"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <center><small style="color: #fff;font-size: 12px;"> Notificación generada
                            automáticamente</small></center>
                    <table class="spacer" role="presentation" border="0" cellpadding="0" cellspacing="0"
                        style="width: 100%;height: 30px;">
                        <tbody>
                            <tr>
                                <td width="100%" height="30"></td>
                            </tr>
                        </tbody>
                    </table>
                </td><!--[if mso]>
 <td></td> <![endif]-->
            </tr>
        </tbody>
    </table>
</body>

</html>
