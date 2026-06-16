<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Evaluación de proveedor</title>
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
</head>

<body style="background-color: #cc2647;">
    <table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #cc2647;">
        <tbody>
            <tr>
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
                                        <img class="img-fluid" src="{{ asset('images/logo-app.png') }}"
                                            style="width: 174px;">

                                        <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="20"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="btn btn-success btn-md btn-rounded" border="0" cellpadding="0"
                                            cellspacing="0" role="presentation"
                                            style="text-align: center;width: 200px; background-color:#cc2647;border-radius: 6px;">
                                            <tbody>
                                                <tr>
                                                    <td class="btn-content"
                                                        style="padding: 10px 20px; border: none;cursor: pointer;vertical-align: middle;font-weight: 800;">
                                                        <a href="https://app.gptsatech.com"
                                                            style="color: #fff;text-decoration: none;">VER</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <h1
                                            style="background-color: #ffffff;font-size: 18px;font-family: Roboto, sans-serif;color: #162d4d;text-transform: uppercase;">
                                            Evaluación de proveedor</h1>

                                        <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 10px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="10"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        {{-- Aviso importante --}}
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                            style="width: 100%;border-radius: 6px;background-color: #fff8e1;border-left: 4px solid #f59e0b;margin-bottom: 16px;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 12px 16px;">
                                                        <p
                                                            style="margin: 0;font-size: 13px;font-family: Roboto, sans-serif;color: #92400e;font-weight: bold;">
                                                            &#9888; Importante
                                                        </p>
                                                        <p
                                                            style="margin: 6px 0 0;font-size: 12px;font-family: Roboto, sans-serif;color: #92400e;">
                                                            Esta evaluación debe completarse únicamente
                                                            <strong>una vez que el
                                                                {{ $data['type'] === 'servicio' ? 'servicio haya sido concluido' : 'producto haya sido entregado' }}</strong>.
                                                            Por favor no la llenes antes de que esto ocurra.
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <p
                                            style="font-size: 13px;font-family: Roboto, sans-serif;color: #343a40;text-align: left;margin: 0 0 16px;">
                                            Hola <strong>{{ $data['respondent_name'] }}</strong>,<br><br>
                                            Se ha generado una nueva evaluación de proveedor asociada a la siguiente
                                            orden de compra. Cuando el
                                            {{ $data['type'] === 'servicio' ? 'servicio esté concluido' : 'producto haya sido entregado' }},
                                            ingresa al sistema y completa tu evaluación.
                                        </p>

                                        {{-- Datos de la OC --}}
                                        <table class="table table-borderless" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td style="font-size: 12px;font-family: Roboto;padding:4px;width: 130px;"
                                                        width="130">Compañía</td>
                                                    <td
                                                        style="font-size: 12px;font-family: Roboto;padding:4px;text-align: left;font-weight: bold;color: #343a40;">
                                                        {{ $data['company'] }}</td>
                                                    <td style="font-size: 12px;font-family: Roboto;padding:4px;width: 160px;"
                                                        width="160">No. orden de compra</td>
                                                    <td
                                                        style="font-size: 12px;font-family: Roboto;padding:4px;font-weight: bold;color: #343a40;">
                                                        {{ $data['folio'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 12px;font-family: Roboto;padding:4px;">
                                                        Proveedor</td>
                                                    <td
                                                        style="font-size: 12px;font-family: Roboto;padding:4px;text-align: left;font-weight: bold;color: #343a40;">
                                                        {{ $data['provider'] }}</td>
                                                    <td style="font-size: 12px;font-family: Roboto;padding:4px;">
                                                        Requisición</td>
                                                    <td
                                                        style="font-size: 12px;font-family: Roboto;padding:4px;font-weight: bold;color: #343a40;">
                                                        {{ $data['requisition_folio'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 12px;font-family: Roboto;padding:4px;">
                                                        Comprador</td>
                                                    <td
                                                        style="font-size: 12px;font-family: Roboto;padding:4px;text-align: left;font-weight: bold;color: #343a40;">
                                                        {{ $data['purchaser'] }}</td>
                                                    <td style="font-size: 12px;font-family: Roboto;padding:4px;">
                                                        Tipo</td>
                                                    <td
                                                        style="font-size: 12px;font-family: Roboto;padding:4px;font-weight: bold;color: #343a40;text-transform: capitalize;">
                                                        {{ $data['type'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 12px;font-family: Roboto;padding:4px;">
                                                        Tu rol en la evaluación</td>
                                                    <td colspan="3"
                                                        style="font-size: 12px;font-family: Roboto;padding:4px;font-weight: bold;color: #cc2647;text-transform: capitalize;">
                                                        {{ $data['respondent_role'] }}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="20"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="btn btn-success btn-md btn-rounded" border="0"
                                            cellpadding="0" cellspacing="0" role="presentation"
                                            style="text-align: center;width: 260px;background-color:#cc2647;border-radius: 6px;margin: 0 auto;">
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="padding: 12px 24px;border: none;cursor: pointer;vertical-align: middle;font-weight: 800;">
                                                        <a href="https://app.gptsatech.com"
                                                            style="color: #fff;text-decoration: none;font-size: 13px;font-family: Roboto, sans-serif;">
                                                            Ir a mis evaluaciones
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="20"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <p
                                            style="font-size: 11px;font-family: Roboto, sans-serif;color: #6c757d;text-align: center;margin: 0;">
                                            Este correo es generado automáticamente por el sistema de compras GPT
                                            Satech. Por favor no respondas a este mensaje.
                                        </p>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="spacer" role="presentation" border="0" cellpadding="0" cellspacing="0"
                        style="width: 100%;height: 30px;">
                        <tbody>
                            <tr>
                                <td width="100%" height="30"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
