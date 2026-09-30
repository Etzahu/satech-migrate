<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Pendientes por revisar</title>
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
</head>

@php
    $text = 'font-size: 13px;font-family: Roboto, sans-serif;color: #343a40;line-height: 1.6;';
    $muted = 'font-size: 12px;font-family: Roboto, sans-serif;color: #6c6c6c;line-height: 1.6;';
    $heading = 'font-size: 14px;font-family: Roboto, sans-serif;color: #162d4d;font-weight: bold;margin: 24px 0 6px;';
    $cell = 'font-size: 12px;border: 1px solid #dee2e6;padding: 6px 8px;font-family: Roboto, sans-serif;color: #343a40;';
    $head = $cell.'background-color: #f1f3f5;font-weight: bold;text-align: left;';
    $link = 'color: #cc2647;text-decoration: none;font-weight: bold;';
@endphp

<body style="background-color: #cc2647;">
    <table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #cc2647;">
        <tbody>
            <tr>
                <td class="body-content"
                    style="color: #343a40;font-family: Roboto, sans-serif; -webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;padding: 30px 0;">

                    <table class="container" width="100%" border="0" cellpadding="0" cellspacing="0"
                        role="presentation" style="max-width: 680px;margin: 0 auto;">
                        <tbody>
                            <tr>
                                <td class="container-content"
                                    style="border-radius: 10px;background-color: #ffffff;padding: 30px;">

                                    <center>
                                        <img class="img-fluid" src="{{ asset('images/logo-app.png') }}"
                                            style="width: 174px;max-width: 100% !important;display: block; height: auto;">
                                        <h1
                                            style="font-size: 18px;font-family: Roboto, sans-serif;color: #162d4d;text-transform: uppercase;margin: 20px 0;">
                                            Pendientes por revisar</h1>
                                    </center>

                                    <p style="{{ $text }}margin: 0 0 12px;">
                                        Hola, {{ $recipient->name }}.
                                    </p>

                                    <p style="{{ $text }}margin: 0 0 12px;">
                                        {{ count($items) === 1 ? 'Este documento sigue esperando' : 'Estos documentos siguen esperando' }}
                                        tu respuesta en el Sistema de Compras. Hasta que
                                        {{ count($items) === 1 ? 'lo atiendas, no puede' : 'los atiendas, no pueden' }}
                                        pasar al siguiente nivel.
                                    </p>

                                    <p style="{{ $muted }}margin: 0 0 10px;">
                                        Cada folio abre el documento en tu bandeja. Si no aparece, revisa que en el
                                        menú superior esté seleccionada la empresa del documento.
                                    </p>

                                    @foreach ($companies as $company => $companyItems)
                                        @if (filled($company))
                                            <p style="{{ $heading }}">{{ $company }}</p>
                                        @endif

                                        <table border="0" cellpadding="0" cellspacing="0"
                                            style="width: 100%;border-collapse: collapse;margin: 0 0 8px;">
                                            <thead>
                                                <tr>
                                                    <th style="{{ $head }}">Documento</th>
                                                    <th style="{{ $head }}">Folio</th>
                                                    <th style="{{ $head }}">Qué falta</th>
                                                    <th style="{{ $head }}">Solicitante</th>
                                                    <th style="{{ $head }}text-align: right;">Días en espera</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($companyItems as $item)
                                                    <tr>
                                                        <td style="{{ $cell }}">{{ $item['type'] }}</td>
                                                        <td style="{{ $cell }}"><a href="{{ $item['url'] }}" style="{{ $link }}">{{ $item['folio'] }}</a></td>
                                                        <td style="{{ $cell }}">{{ $item['action'] }}</td>
                                                        <td style="{{ $cell }}">{{ $item['requester'] ?? '—' }}</td>
                                                        <td style="{{ $cell }}text-align: right;">{{ $item['days'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach

                                    <p style="font-size: 11px;font-family: Roboto, sans-serif;color: #6c6c6c;line-height: 1.6;margin: 24px 0 0;text-align: center;">
                                        Recibirás este recordatorio mientras tengas documentos pendientes por revisar.
                                    </p>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <center><small style="color: #fff;font-size: 12px;">Notificación generada desde el Sistema de
                            Compras</small></center>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
