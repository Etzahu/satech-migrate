<!doctype html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orden de compra</title>
    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        @page {
            margin: 110px 80px 80px 80px;
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

        p {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    {{-- cabecera --}}
    <header>
        <table class="w-full" style="border: none;">
            <tr>
                <td align="left" valign="top" style="border: none;">
                    @if ($rq->company->acronym == 'T')
                        <img src="{{ asset('images/logo/companies/T.png') }}" alt="logo" width="180px" />
                    @elseif ($rq->company->acronym == 'G')
                        <img src="{{ asset('images/logo/companies/G.jpg') }}" alt="logo" width="180px" />
                    @endif
                </td>
                <td style="border: none;">

                </td>
                <td align="center" valing="middle" width="250px" style="border: none;">
                    <div style="text-align: right;">
                        <p style="font-weight: bold;color:#C8102E;">Orden de compra: G203-24</p>
                        <p style="font-weight: bold;">Revisión: 0</p>
                        <p style="font-weight: bold;font-size:11px;">26 de noviembre del 2024</p>
                        <p style="font-size: 12px;">Requisicion: T-SG24-375</p>
                        <p style="font-size: 12px;">Página 1 de 4</p>
                    </div>
                </td>
        </table>
    </header>
    <br>
    <table class="w-full" style="border: none;margin-top:30px;">
        <tr>
            <td align="center" valing="middle" style="border: none;">
                <div style="text-align: left;">
                    <p style="font-weight: bold;">GPT Ingenieria y Manufactura Sa de CV</p>
                    <p style="font-size: 12px;">Av. Santa Monica</p>
                    <p style="font-size: 12px;">Coloni</p>
                    <p style="font-size: 12px;">Municipo</p>
                    <p style="font-size: 12px;">Estado y CP</p>

                </div>
            </td>
    </table>
    <br>
    <table class="w-full">
        <tr>
            <td>
                <table class="w-full">
                    <tr>
                        <td colspan="2" style="background-color:#F6BE00;">
                            <p style="font-weight: bold;">Proveedor</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Para:</p>
                        </td>
                        <td>
                            <p>Para:</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            No. Telefonico
                        </td>
                        <td>
                            No. Telefonico
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 10%;">
            </td>
            <td>
                <table class="w-full">
                    <tr>
                        <td>
                            <p>Proveedor</p>
                        </td>
                        <td>
                            <p>Proveedor</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Para:</p>
                        </td>
                        <td>
                            <p>Para:</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            No. Telefonico
                        </td>
                        <td>
                            No. Telefonico
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <footer>
        <img src="{{ asset('images/watermark.jpg') }}" alt="watermark" style="height: 50px;">
    </footer>
</body>

</html>
