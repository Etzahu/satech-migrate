<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Bienvenido a SA-TECH</title>
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
                <td class="body-content"
                    style="color: #343a40;font-family: Roboto, sans-serif; -webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%">

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
                                        <!--[if mso]><img class="img-fluid" src="{{ asset('images/logo-app.png') }}" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
                                            class="img-fluid" src="{{ asset('images/logo-app.png') }}"
                                            style="width: 174px;max-width: 100% !important;display: block; height: auto;"><!--<![endif]-->

                                        <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="20"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <h1
                                            style="background-color: #ffffff;font-size: 18px;font-family: Roboto, sans-serif;color: #162d4d;text-transform: uppercase;margin: 0;">
                                            Bienvenido al Sistema de Compras</h1>

                                        <table class="spacer" role="presentation" border="0" cellpadding="0"
                                            cellspacing="0" style="width: 100%;height: 20px;">
                                            <tbody>
                                                <tr>
                                                    <td width="100%" height="20"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </center>

                                    {{-- Saludo y presentación --}}
                                    <p style="font-size: 13px;font-family: Roboto, sans-serif;color: #343a40;margin: 0 0 12px;">
                                        Hola <strong style="color: #162d4d;">{{ $recipient->name }}</strong>,
                                    </p>

                                    <p style="font-size: 13px;font-family: Roboto, sans-serif;color: #343a40;line-height: 1.6;margin: 0 0 12px;">
                                        Tu cuenta en <strong style="color: #162d4d;">SA-TECH · Sistema de Compras</strong>
                                        ya está activa. Se accede con este mismo correo institucional desde el botón que
                                        aparece más abajo.
                                    </p>

                                    @if (filled($note))
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                            style="width: 100%;border-left: 4px solid #cc2647;background-color: #fdf2f4;border-radius: 4px;margin: 0 0 16px;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 12px 14px;font-size: 13px;font-family: Roboto, sans-serif;color: #343a40;line-height: 1.6;">
                                                        {!! nl2br(e($note)) !!}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endif

                                    {{-- Datos de la cuenta --}}
                                    <table class="table table-borderless" border="0" cellpadding="0" cellspacing="0"
                                        style="width: 100%;margin: 0 0 20px;border-collapse: collapse;">
                                        <tbody>
                                            <tr>
                                                <td style="padding:4px;font-size: 12px;font-family: Roboto, sans-serif;width: 110px;"
                                                    width="110">Usuario</td>
                                                <td style="padding:4px;font-size: 12px;font-family: Roboto, sans-serif;text-align: left;font-weight: bold;color: #343a40;">
                                                    {{ $recipient->email }}</td>
                                            </tr>
                                            @if ($recipient->management)
                                                <tr>
                                                    <td style="padding:4px;font-size: 12px;font-family: Roboto, sans-serif;width: 110px;"
                                                        width="110">Gerencia</td>
                                                    <td style="padding:4px;font-size: 12px;font-family: Roboto, sans-serif;text-align: left;font-weight: bold;color: #343a40;">
                                                        {{ $recipient->management->name }}</td>
                                                </tr>
                                            @endif
                                            @if (filled($recipient->puesto))
                                                <tr>
                                                    <td style="padding:4px;font-size: 12px;font-family: Roboto, sans-serif;width: 110px;"
                                                        width="110">Puesto</td>
                                                    <td style="padding:4px;font-size: 12px;font-family: Roboto, sans-serif;text-align: left;font-weight: bold;color: #343a40;">
                                                        {{ $recipient->puesto }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                    {{-- Guías adjuntas --}}
                                    @if (count($attachedGuides))
                                        <p style="font-size: 13px;font-family: Roboto, sans-serif;color: #162d4d;font-weight: bold;margin: 0 0 8px;">
                                            @if (count($attachedGuides) === 1)
                                                Adjunto encontrarás la guía que necesitas para empezar:
                                            @else
                                                Adjuntas encontrarás {{ count($attachedGuides) }} guías de uso para empezar:
                                            @endif
                                        </p>

                                        <table class="table table-bordered" border="0" cellpadding="0" cellspacing="0"
                                            style="border-radius: 6px;border: 1px solid #6c6c6c;width: 100%;border-collapse: collapse;margin: 0 0 20px;">
                                            <tbody>
                                                @foreach ($attachedGuides as $guide)
                                                    <tr>
                                                        <td style="font-size: 12px;border: 1px solid #6c6c6c;padding: 8px 10px;font-family: Roboto, sans-serif;color: #343a40;line-height: 1.5;">
                                                            <strong style="color: #162d4d;font-size: 13px;">{{ $guide['title'] }}</strong><br>
                                                            <span style="color: #6c6c6c;">{{ $guide['description'] }}</span><br>
                                                            <span style="color: #cc2647;font-size: 11px;">Archivo adjunto: {{ $guide['pdf'] }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <p style="font-size: 12px;font-family: Roboto, sans-serif;color: #6c6c6c;line-height: 1.6;margin: 0 0 20px;">
                                            Estas mismas guías, junto con las demás, están siempre disponibles dentro
                                            del sistema en el menú lateral, en <strong style="color: #343a40;">Guías de uso</strong>.
                                        </p>
                                    @else
                                        <p style="font-size: 12px;font-family: Roboto, sans-serif;color: #6c6c6c;line-height: 1.6;margin: 0 0 20px;">
                                            Dentro del sistema, en el menú lateral, encontrarás la sección
                                            <strong style="color: #343a40;">Guías de uso</strong> con el material
                                            correspondiente a tu perfil.
                                        </p>
                                    @endif

                                    <center>
                                        <table class="btn btn-success btn-md btn-rounded" border="0" cellpadding="0"
                                            cellspacing="0" role="presentation"
                                            style="text-align: center;width: 220px; background-color:#cc2647;border-radius: 6px;">
                                            <tbody>
                                                <tr>
                                                    <td class="btn-content"
                                                        style="padding: 10px 20px; border: none;cursor: pointer;vertical-align: middle;font-weight: 800;">
                                                        <a href="https://app.gptsatech.com"
                                                            style="color: #fff;text-decoration: none;">ENTRAR AL SISTEMA</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </center>

                                    <table class="spacer" role="presentation" border="0" cellpadding="0"
                                        cellspacing="0" style="width: 100%;height: 20px;">
                                        <tbody>
                                            <tr>
                                                <td width="100%" height="20"></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <p style="font-size: 11px;font-family: Roboto, sans-serif;color: #6c6c6c;line-height: 1.6;margin: 0;text-align: center;">
                                        Si algo no coincide con lo que esperabas —tu gerencia, tus permisos o los
                                        módulos que ves—, responde a este correo o contacta al administrador del
                                        sistema antes de empezar a capturar.
                                    </p>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <center><small style="color: #fff;font-size: 12px;">Notificación generada desde el Sistema de
                            Compras</small></center>

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
