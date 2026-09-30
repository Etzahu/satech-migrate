<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Revisión del flujo de compras</title>
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
                                            Revisión del flujo de compras</h1>
                                    </center>

                                    <p style="{{ $text }}margin: 0 0 12px;">
                                        Hay niveles del flujo que hoy nadie puede responder. Lo que está en ellos no
                                        avanza, y el aviso que normalmente sale a quien debe firmar no le llega a
                                        nadie.
                                    </p>

                                    {{-- Roles sin titular activo --}}
                                    @if (count($report['vacant_roles']))
                                        <p style="{{ $heading }}">Roles sin titular activo</p>
                                        <p style="{{ $muted }}margin: 0 0 10px;">
                                            Se corrige asignando el rol a quien corresponda, desde la página del rol,
                                            en la pestaña <strong style="color: #343a40;">Usuarios</strong>.
                                        </p>

                                        <table border="0" cellpadding="0" cellspacing="0"
                                            style="width: 100%;border-collapse: collapse;margin: 0 0 8px;">
                                            <tbody>
                                                @foreach ($report['vacant_roles'] as $role)
                                                    <tr>
                                                        <td style="{{ $cell }}line-height: 1.6;">
                                                            <strong style="color: #162d4d;font-size: 13px;">{{ $role['label'] }}</strong>
                                                            <span style="color: #6c6c6c;">({{ $role['role'] }})</span><br>
                                                            @if (count($role['items']))
                                                                <span style="color: #dc2626;font-weight: bold;">
                                                                    {{ count($role['items']) === 1 ? 'Espera 1 documento' : 'Esperan '.count($role['items']).' documentos' }}:
                                                                </span>
                                                                @foreach ($role['items'] as $item)
                                                                    <a href="{{ $item['url'] }}" style="{{ $link }}">{{ $item['folio'] }}</a>@if (! $loop->last), @endif
                                                                @endforeach
                                                            @else
                                                                <span style="color: #6c6c6c;">Nada esperando por ahora; el primer documento que llegue a este nivel se va a detener.</span>
                                                            @endif
                                                            @if ($role['url'])
                                                                <br><a href="{{ $role['url'] }}" style="{{ $link }}">Abrir el rol</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif

                                    {{-- Pendientes que esperan a una cuenta inactiva --}}
                                    @if (count($report['inactive']))
                                        <p style="{{ $heading }}">Pendientes que esperan a una cuenta inactiva</p>
                                        <p style="{{ $muted }}margin: 0 0 10px;">
                                            Se corrige cambiando la cadena de aprobación o reasignando el documento; si
                                            ya no procede, cancélalo. Lo que lleva más de {{ $idleDays }} días sin
                                            moverse no aparece aquí: se da por abandonado.
                                        </p>

                                        @foreach ($report['inactive'] as $group)
                                            <p style="{{ $text }}margin: 12px 0 4px;">
                                                <strong style="color: #162d4d;">{{ $group['name'] }}</strong>
                                                @if ($group['user_id'])
                                                    <span style="color: #dc2626;">· cuenta inactiva</span>
                                                @endif
                                            </p>

                                            <table border="0" cellpadding="0" cellspacing="0"
                                                style="width: 100%;border-collapse: collapse;margin: 0 0 8px;">
                                                <thead>
                                                    <tr>
                                                        <th style="{{ $head }}">Documento</th>
                                                        <th style="{{ $head }}">Folio</th>
                                                        <th style="{{ $head }}">Nivel</th>
                                                        <th style="{{ $head }}text-align: right;">Días sin moverse</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($group['items'] as $item)
                                                        <tr>
                                                            <td style="{{ $cell }}">{{ $item['type'] }}</td>
                                                            <td style="{{ $cell }}"><a href="{{ $item['url'] }}" style="{{ $link }}">{{ $item['folio'] }}</a></td>
                                                            <td style="{{ $cell }}">{{ $item['level'] }}</td>
                                                            <td style="{{ $cell }}text-align: right;">{{ $item['days'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endforeach
                                    @endif

                                    <p style="font-size: 11px;font-family: Roboto, sans-serif;color: #6c6c6c;line-height: 1.6;margin: 24px 0 0;text-align: center;">
                                        Este aviso se manda cada día hábil mientras haya algo que corregir.
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
