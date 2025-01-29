<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Requisición de compra</title>
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <style type="text/css">

    </style>
    <!--[if !mso]><!-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
    <!--<![endif]-->
</head>

<body style="background-color: #cc2647;">
    <table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #cc2647;">
        <tbody>
            <tr><!--[if mso]>
 <td></td> <![endif]-->
                <td class="body-content" style="color: #343a40;font-family: Roboto, sans-serif; -webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%">
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
                                    style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: #dee2e6;">
                                    <center>
                                        <!--[if mso]><img class="img-fluid" src="{{ asset('images/watermark.jpg') }}" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
                                            class="img-fluid" src="{{ asset('images/watermark.jpg') }}"
                                            style="width: 174px;max-width: 100% !important;display: block; height: auto;"><!--<![endif]-->
                                            <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="20"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        @if(!$data['informative'])
                                        <table class="btn btn-success btn-md btn-rounded" border="0"
                                        cellpadding="0" cellspacing="0" role="presentation" style="text-align: center;width: 200px; background-color:#cc2647;border-radius: 6px;">
                                        <tbody>
                                            <tr>
                                                <td class="btn-content" style=" padding: 10px 20px; border: none;cursor: pointer;vertical-align: middle;font-weight: 800;"><a href="https://app.gptsatech.com" style="color: #fff;text-decoration: none;">VER</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @endif
                                        <h1
                                            style="background-color: #ffffff;font-size: 18px;font-family: Roboto, sans-serif;color: #162d4d;text-transform: uppercase;">
                                            Requisición de compra</h1>
                                        <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="20"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-borderless" style=" width: 100%;margin-bottom: 16px;border-collapse: collapse;" border="0" cellpadding="0"
                                            cellspacing="0">
                                            <thead>
                                                <tr></tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding: 4px;width: 48.906px;"
                                                        width="48.906">Compañía</td>
                                                    <td
                                                        style="font-size: 12px;font-family: 'Roboto';padding: 4px;text-align: left;font-weight: bold;color: #343a40;">
                                                        {{ $data['company'] }}</td>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding: 4px;width: 110.062px;"
                                                        width="110.062">No. de requisición</td>
                                                    <td
                                                        style="font-size: 12px;font-family: 'Roboto';padding: 4px;font-weight: bold;color: #343a40;">
                                                        {{ $data['folio'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding: 4px;">Gerencia</td>
                                                    <td
                                                        style="font-size: 12px;font-family: 'Roboto';padding: 4px;text-align: left;font-weight: bold;color: #343a40;">
                                                        {{ $data['management'] }}</td>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding: 4px;">Fecha solicitada
                                                    </td>
                                                    <td
                                                        style="font-size: 12px;font-family: 'Roboto';padding: 4px;font-weight: bold;color: #343a40;">
                                                        {{ $data['created_at'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding: 4px;">Proyecto</td>
                                                    <td
                                                        style="font-size: 12px;font-family: 'Roboto';padding: 4px;font-weight: bold;color: #343a40;">
                                                        {{ $data['project'] }}</td>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding: 4px;">Fecha requerida
                                                    </td>
                                                    <td
                                                        style="font-size: 12px;font-family: 'Roboto';padding: 4px;font-weight: bold;color: #343a40;">
                                                        {{ $data['date_delivery'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding: 4px;">Solicitante</td>
                                                    <td colspan="3"
                                                        style="font-size: 12px;font-family: 'Roboto';padding: 4px;text-align: left;font-weight: bold;color: #343a40;">
                                                        {{ $data['requester'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 12px;font-family: 'Roboto';padding: 4px;">Lugar de entrega
                                                    </td>
                                                    <td colspan="3"
                                                        style="font-size: 12px;font-family: 'Roboto';padding: 4px;font-weight: bold;color: #343a40;">
                                                        {{ $data['delivery_address'] }}</td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr></tr>
                                            </tbody>
                                        </table>

                                        @if ($data['items'])
                                            <table class="table table-bordered" border="0" cellpadding="0"
                                                cellspacing="0" style="border-radius: 6px;border: 1px solid #6c6c6c;width: 100%;border-collapse: collapse;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4"
                                                            style="color: #162d4d;font-weight: bold;font-size: 14px;border: 1px solid #6c6c6c;padding:4px;">
                                                            PARTIDAS</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center"
                                                            style="font-size: 12px;border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;font-weight: bold;color: #343a40;width: 27.609px;"
                                                            width="27.609">Código</td>
                                                        <td class="text-center"
                                                            style="font-size: 12px;border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;font-weight: bold;color: #343a40;">
                                                            Producto/Servicio</td>
                                                        <td class="text-center"
                                                            style="font-family: Roboto, sans-serif;color: #343a40;font-size: 12px;border: 1px solid #6c6c6c;padding:4px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
                                                            width="74.406">Unidad</td>
                                                        <td class="text-center"
                                                            style="font-family: Roboto, sans-serif;color: #343a40;font-size: 12px;border: 1px solid #6c6c6c;padding:4px;font-weight: bold;width: 56.047px;"
                                                            width="56.047">Cantidad</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['items'] as $item)
                                                        <tr>
                                                            <td
                                                                style="font-size: 12px;border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;">
                                                                {{ $item['code'] }}</td>
                                                            <td
                                                                style="font-size: 12px;border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;">
                                                                {{ $item['product'] }}</td>
                                                            <td
                                                                style="font-size: 12px;border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;">
                                                                {{ $item['um'] }}</td>
                                                            <td
                                                                style="font-size: 12px;border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;">
                                                                {{ $item['quantity_purchase'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered" border="0" cellpadding="0"
                                                cellspacing="0" style="border-radius: 6px;width: 100%;border-collapse: collapse;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4"
                                                            style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;padding:4px;">
                                                            Observaciones de las partidas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['items'] as $item)
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
                                            cellspacing="0" style="border-radius: 6px;width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th colspan="2"
                                                        style="color: #162d4d;font-weight: bold;font-size: 14px;padding:4px;">
                                                        OBSERVACIONES O NOTAS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="font-family: Roboto, sans-serif;color: #343a40;border: 1px solid #6c6c6c;padding:4px;">
                                                        <p class="text-justify" style="font-size: 12px;">
                                                            {{ $data['observation'] }}</p>
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
