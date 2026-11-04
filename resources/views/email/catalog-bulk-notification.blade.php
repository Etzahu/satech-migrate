@php
    $first = $products->first();
@endphp
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Alta</title>
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
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
                                    style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 20px;padding-bottom: 30px;padding-left: 20px;">
                                    <center>
                                        <img class="img-fluid" src="{{ asset('images/logo/logotipo_GPT.png') }}"
                                            style="width: 174px;" width="174">
                                        <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="20"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <h1
                                            style="background-color: #ffffff;font-size: 18px;font-family: Roboto, sans-serif;color: #162d4d;">
                                            Alta de productos/servicios</h1>
                                        <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="20"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td style="padding:4px;font-size: 12px;font-family: 'Roboto';">Estatus</td>
                                                    <td
                                                        style="padding:4px;font-size: 12px;font-family: 'Roboto';text-align: left;font-weight: bold;text-transform: capitalize;">
                                                        {{ $first->status }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px;font-size: 12px;font-family: 'Roboto';">Compañía</td>
                                                    <td
                                                        style="padding:4px;font-size: 12px;font-family: 'Roboto';text-align: left;font-weight: bold;">
                                                        {{ $first->company?->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px;font-size: 12px;font-family: 'Roboto';">Solicitante</td>
                                                    <td
                                                        style="padding:4px;font-size: 12px;font-family: 'Roboto';text-align: left;font-weight: bold;">
                                                        {{ $first->requester?->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px;font-size: 12px;font-family: 'Roboto';">Elementos</td>
                                                    <td
                                                        style="padding:4px;font-size: 12px;font-family: 'Roboto';text-align: left;font-weight: bold;">
                                                        {{ $products->count() }}</td>
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
                                        <table border="0" cellpadding="0" cellspacing="0"
                                            style="border: 1px solid #6c6c6c;width: 100%;border-collapse: collapse;">
                                            <thead>
                                                <tr>
                                                    <th
                                                        style="color: #162d4d;font-size: 14px;border: 1px solid #6c6c6c;padding:4px;">
                                                        Tipo</th>
                                                    <th
                                                        style="color: #162d4d;font-size: 14px;border: 1px solid #6c6c6c;padding:4px;">
                                                        Descripción</th>
                                                    <th
                                                        style="color: #162d4d;font-size: 14px;border: 1px solid #6c6c6c;padding:4px;">
                                                        Unidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $product)
                                                    <tr>
                                                        <td
                                                            style="font-size: 12px;border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;color: #343a40;">
                                                            {{ $product->type_purchase === 'servicio' ? 'Servicio' : 'Producto' }}</td>
                                                        <td
                                                            style="font-size: 12px;border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;font-weight: bold;color: #343a40;">
                                                            {{ $product->name }}</td>
                                                        <td
                                                            style="font-size: 12px;border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;color: #343a40;">
                                                            {{ $product->unit?->name }}</td>
                                                    </tr>
                                                @endforeach
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
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                            style="text-align: center;width: 200px; background-color:#cc2647;border-radius: 6px;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 10px 20px;font-weight: 800;"><a
                                                            href="https://app.gptsatech.com"
                                                            style="color: #fff;text-decoration: none;">VER</a></td>
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
