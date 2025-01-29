<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Alta</title>
    <link rel="stylesheet" href="assets/css/framework.min.css">
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
                <td class="body-content" style="color: var(--dark);font-family: Roboto, sans-serif;">
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
                                    style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 20px;padding-bottom: 30px;padding-left: 20px;border-width: 1px;border-color: var(--gray-light);">
                                    <center>
                                        <!--[if mso]><img class="img-fluid" src="assets/img/logotipo_GPT.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
                                            class="img-fluid" src="{{ asset('images/logo/logotipo_GPT.png') }}"
                                            style="width: 174px;"><!--<![endif]-->
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
                                            Alta de producto/servicio</h1>
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
                                                    <td style="padding:4px;font-size: 12px;font-family: 'Roboto';width: 48.906px;"
                                                        width="48.906">Estatus</td>
                                                    <td
                                                        style="padding:4px;font-size: 12px;font-family: 'Roboto';text-align: left;font-weight: bold;color: var(--dark);text-transform: capitalize;">
                                                        {{ $data['status'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px;font-size: 12px;font-family: 'Roboto';width: 48.906px;"
                                                        width="48.906">Compañía</td>
                                                    <td
                                                        style="padding:4px;font-size: 12px;font-family: 'Roboto';text-align: left;font-weight: bold;color: var(--dark);">
                                                        {{ $data['company']['name'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px;font-size: 12px;font-family: 'Roboto';width: 48.906px;"
                                                        width="48.906">Solicitante</td>
                                                    <td
                                                        style="padding:4px;font-size: 12px;font-family: 'Roboto';text-align: left;font-weight: bold;color: var(--dark);">
                                                        {{ $data['requester']['name'] }}</td>
                                                </tr>
                                                <tr></tr>
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
                                        <table class="table table-bordered" border="0" cellpadding="0"
                                            cellspacing="0" style="border-radius: 6px;border: 1px solid #6c6c6c;width: 100%;border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td class="text-center"
                                                        style="color: #162d4d;padding:4px;font-weight: bold;font-size: 14px;border: 1px solid #6c6c6c;padding:4px;">
                                                        Producto/Servicio</td>
                                                    <td class="text-center"
                                                        style="color: #162d4d;padding:4px;font-weight: bold;font-size: 14px;border: 1px solid #6c6c6c;padding:4px;"
                                                        width="74.406">Unidad</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 12px;border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;font-weight: bold;color: #343a40;padding:4px;">
                                                        {{ $data['name'] }}</td>
                                                    <td style="font-size: 12px;border: 1px solid #6c6c6c;padding:4px;font-family: Roboto, sans-serif;font-weight: bold;color: #343a40;padding:4px;">
                                                        {{ $data['unit']['name'] }}</td>
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
                                        <table class="btn btn-success btn-md btn-rounded" border="0"
                                        cellpadding="0" cellspacing="0" role="presentation" style="text-align: center;width: 200px; background-color:#cc2647;border-radius: 6px;">
                                        <tbody>
                                            <tr>
                                                <td class="btn-content" style=" padding: 10px 20px; border: none;cursor: pointer;vertical-align: middle;font-weight: 800;"><a href="https://app.gptsatech.com" style="color: #fff;text-decoration: none;">VER</a></td>
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
