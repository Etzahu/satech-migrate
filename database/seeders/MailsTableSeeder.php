<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('mails')->delete();

        \DB::table('mails')->insert(array(
            0 =>
            array(
                'id' => 1,
                'uuid' => '54acd1ae-e2ba-478e-81fc-957261677421',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR REQUISICIÓN:G-SG-2025-0001',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0001</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-006/24-NP-006/24-Mantenimiento Mensual Junio 2024</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
01-02-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Mollitia harum harum</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070006</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Metalico 1.3975X1.8755X.2875</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => NULL,
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 01:28:33',
                'updated_at' => '2025-01-25 01:28:33',
            ),
            1 =>
            array(
                'id' => 2,
                'uuid' => '8a0ea593-06be-4794-b446-11937e011e14',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR REQUISICIÓN:G-SG-2025-0001',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0001</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-006/24-NP-006/24-Mantenimiento Mensual Junio 2024</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
01-02-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Mollitia harum harum</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070006</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Metalico 1.3975X1.8755X.2875</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 01:29:31',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 01:29:31',
                'updated_at' => '2025-01-25 01:29:31',
            ),
            2 =>
            array(
                'id' => 3,
                'uuid' => '4b464fc2-3732-4bc0-bc93-ab9a34eba5df',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'APROBAR REQUISICIÓN:G-SG-2025-0001',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0001</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-006/24-NP-006/24-Mantenimiento Mensual Junio 2024</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
01-02-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Mollitia harum harum</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070006</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Metalico 1.3975X1.8755X.2875</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 01:29:54',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 01:29:53',
                'updated_at' => '2025-01-25 01:29:54',
            ),
            3 =>
            array(
                'id' => 4,
                'uuid' => 'd82b0777-059d-495a-93d3-b19b1d481041',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'APROBADO POR DIRECCIÓN GENERAL REQUISICIÓN:G-SG-2025-0001',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0001</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-006/24-NP-006/24-Mantenimiento Mensual Junio 2024</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
01-02-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Mollitia harum harum</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070006</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Metalico 1.3975X1.8755X.2875</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 01:30:22',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 01:30:22',
                'updated_at' => '2025-01-25 01:30:22',
            ),
            4 =>
            array(
                'id' => 5,
                'uuid' => '20b5cab8-81df-4af0-a15f-bbf6e5fc7252',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'COLOCAR ORDEN DE COMPRA REQUISICIÓN:G-SG-2025-0001',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0001</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-006/24-NP-006/24-Mantenimiento Mensual Junio 2024</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
01-02-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Mollitia harum harum</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070006</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Metalico 1.3975X1.8755X.2875</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 01:34:26',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 01:34:26',
                'updated_at' => '2025-01-25 01:34:26',
            ),
            5 =>
            array(
                'id' => 6,
                'uuid' => 'c90f20f0-a31c-4572-baae-e1aaca7af71e',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR EXISTENCIA REQUISICIÓN:G-SG-2025-0002',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0002</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
26-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Fugit quae et nesci</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070019</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Pit 1.187X1.687X.250</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 02:45:08',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 02:45:08',
                'updated_at' => '2025-01-25 02:45:08',
            ),
            6 =>
            array(
                'id' => 7,
                'uuid' => '44881efd-4d48-4d25-a1d9-d474e139f605',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'DEVUELTO POR ALMACÉN REQUISICIÓN:G-SG-2025-0002',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0002</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
26-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Fugit quae et nesci</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070019</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Pit 1.187X1.687X.250</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 02:45:21',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 02:45:21',
                'updated_at' => '2025-01-25 02:45:21',
            ),
            7 =>
            array(
                'id' => 8,
                'uuid' => '6456390c-479f-4ee7-a4cc-ca0f6a9d3057',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR EXISTENCIA REQUISICIÓN:G-SG-2025-0002',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0002</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
26-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Fugit quae et nesci</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070019</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Pit 1.187X1.687X.250</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 02:45:30',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 02:45:30',
                'updated_at' => '2025-01-25 02:45:30',
            ),
            8 =>
            array(
                'id' => 9,
                'uuid' => 'c92c23a4-0087-44fa-94a5-950cc25b416b',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'DEVUELTO POR ALMACÉN REQUISICIÓN:G-SG-2025-0002',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0002</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
26-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Fugit quae et nesci</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070019</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Pit 1.187X1.687X.250</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 02:45:42',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 02:45:41',
                'updated_at' => '2025-01-25 02:45:42',
            ),
            9 =>
            array(
                'id' => 10,
                'uuid' => 'e50caf66-017b-482c-a495-07deca6f9ce5',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR EXISTENCIA REQUISICIÓN:G-SG-2025-0002',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0002</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
26-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Fugit quae et nesci</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070019</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Pit 1.187X1.687X.250</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 02:46:02',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 02:46:02',
                'updated_at' => '2025-01-25 02:46:02',
            ),
            10 =>
            array(
                'id' => 11,
                'uuid' => '7e6ca316-10f8-479b-a2d1-cacefc4122c7',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR REQUISICIÓN:G-SG-2025-0002',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0002</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
26-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Fugit quae et nesci</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070019</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Pit 1.187X1.687X.250</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 02:46:12',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 02:46:12',
                'updated_at' => '2025-01-25 02:46:12',
            ),
            11 =>
            array(
                'id' => 12,
                'uuid' => 'fc692264-8e00-461e-91dd-3bb3d72dbd0c',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR EXISTENCIA REQUISICIÓN:G-ING-2025-0001',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-ING-2025-0001</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia De Ingenieria</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-038/24-NP-038/24-HTF Weldolet + brida 24&quot; x 8&quot; 300# RF (2 PZA)</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
28-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Jatziri Yamile Alejo Osorio</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Ipsam voluptas quibu</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070048</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Skf 13534</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 02:59:42',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 02:59:42',
                'updated_at' => '2025-01-25 02:59:42',
            ),
            12 =>
            array(
                'id' => 13,
                'uuid' => '52ee439b-9276-485c-a7fb-76846a14e3bc',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR REQUISICIÓN:G-ING-2025-0001',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-ING-2025-0001</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia De Ingenieria</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-038/24-NP-038/24-HTF Weldolet + brida 24&quot; x 8&quot; 300# RF (2 PZA)</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
28-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Jatziri Yamile Alejo Osorio</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Ipsam voluptas quibu</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070048</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Skf 13534</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
.</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 03:00:04',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 03:00:03',
                'updated_at' => '2025-01-25 03:00:04',
            ),
            13 =>
            array(
                'id' => 14,
                'uuid' => '125a9f52-c3ec-4463-884b-efc8fc3254bd',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR EXISTENCIA REQUISICIÓN:G-SG-2025-0003',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0003</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Ullam praesentium au</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070038</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Viton Sfk 17379</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
Sin observaciones</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 04:29:00',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 04:29:00',
                'updated_at' => '2025-01-25 04:29:00',
            ),
            14 =>
            array(
                'id' => 15,
                'uuid' => 'f7f358fc-7e93-4440-b809-7f24884987d2',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR REQUISICIÓN:G-SG-2025-0003',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0003</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Ullam praesentium au</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070038</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Viton Sfk 17379</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
Sin observaciones</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 04:29:10',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 04:29:09',
                'updated_at' => '2025-01-25 04:29:10',
            ),
            15 =>
            array(
                'id' => 16,
                'uuid' => '01be7fa7-53c4-4768-9e27-150ffd0f9c7d',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR REQUISICIÓN:G-SG-2025-0003',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0003</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Ullam praesentium au</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070038</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Viton Sfk 17379</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
Sin observaciones</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 04:29:27',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 04:29:27',
                'updated_at' => '2025-01-25 04:29:27',
            ),
            16 =>
            array(
                'id' => 17,
                'uuid' => '7fbc7466-99f9-4348-a2a6-8489500f3277',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'APROBAR REQUISICIÓN:G-SG-2025-0003',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0003</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Ullam praesentium au</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070038</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Viton Sfk 17379</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
Sin observaciones</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 04:29:46',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 04:29:46',
                'updated_at' => '2025-01-25 04:29:46',
            ),
            17 =>
            array(
                'id' => 18,
                'uuid' => 'e6738aa6-3078-48ed-8b8c-7ac15e5bb627',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'DEVUELTO POR DIRECCIÓN GENERAL REQUISICIÓN:G-SG-2025-0003',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0003</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Ullam praesentium au</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070038</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Viton Sfk 17379</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
Sin observaciones</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 04:31:16',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 04:31:16',
                'updated_at' => '2025-01-25 04:31:16',
            ),
            18 =>
            array(
                'id' => 19,
                'uuid' => '6dd0aff5-dcf7-47c4-9274-094d966e4ebe',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR EXISTENCIA REQUISICIÓN:G-SG-2025-0003',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0003</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Ullam praesentium au</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070038</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Viton Sfk 17379</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
Sin observaciones</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 04:31:55',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 04:31:55',
                'updated_at' => '2025-01-25 04:31:55',
            ),
            19 =>
            array(
                'id' => 20,
                'uuid' => '2049d90e-4111-4b8d-93dc-8975c284f125',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR REQUISICIÓN:G-SG-2025-0003',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0003</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Ullam praesentium au</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070038</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Viton Sfk 17379</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
Sin observaciones</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 04:32:07',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 04:32:07',
                'updated_at' => '2025-01-25 04:32:07',
            ),
            20 =>
            array(
                'id' => 21,
                'uuid' => '729dfdc6-3a05-40dc-81da-e64baee50d69',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'REVISAR REQUISICIÓN:G-SG-2025-0003',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0003</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Ullam praesentium au</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070038</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Viton Sfk 17379</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
Sin observaciones</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 04:32:26',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 04:32:26',
                'updated_at' => '2025-01-25 04:32:26',
            ),
            21 =>
            array(
                'id' => 22,
                'uuid' => '6547ab48-ddd8-4900-bf2c-b0886d790105',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'APROBAR REQUISICIÓN:G-SG-2025-0003',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0003</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Ullam praesentium au</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070038</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Viton Sfk 17379</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
Sin observaciones</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 04:32:44',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 04:32:44',
                'updated_at' => '2025-01-25 04:32:44',
            ),
            22 =>
            array(
                'id' => 23,
                'uuid' => 'ad6c7a16-bad5-4b97-958f-97790855a11f',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'APROBADO POR DIRECCIÓN GENERAL REQUISICIÓN:G-SG-2025-0003',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Requisición de compra</title>
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
h1,h2,h3,h4,h5,h6,p{mso-line-height-rule:exactly;margin:0 0 10px}blockquote,p{margin:0 0 10px}.btn.btn-block,.col,.col-table,.container,.navbar .collapse.collapse-right,.row,body,html{width:100%}.btn .btn-content,.nav .nav-item,.row>tbody>tr>td{text-align:center}.col,.col-content,.col-table,.container-content,.nav,.navbar,.row>tbody>tr>td{vertical-align:top}body,html{margin:0 auto;padding:0;height:100%;background-color:#fff}.body-content{--primary:#0a6fe4;--secondary:#6c757d;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#dc3545;--light:#f8f9fa;--dark:#343a40;--gray-light:#dee2e6;--gray-dark:#6c6c6c;font-size:16px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;color:#212529;font-weight:400;line-height:1.45;text-align:left;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}a{text-decoration:none;color:var(--primary)}h1,h2,h3,h4,h5,h6{font-weight:700}h1{font-size:175%}h2{font-size:150%}h3{font-size:135%}.btn.btn-lg .btn-content a,h4{font-size:125%}h5{font-size:112.5%}h6{font-size:100%}table{border-collapse:collapse}img.icon,svg.icon{width:1em;height:1em}code{background-color:#eee;padding:2px;font-size:90%}blockquote{border-left:3px solid #ddd;padding:12px 5px 12px 16px;background-color:#fafafa}blockquote p:last-child{margin-bottom:0}.container{max-width:680px;margin:0 auto}.container-content{padding:0;max-width:680px}.container.container-lg,.container.container-lg .container-content{max-width:800px}.container.container-fluid,.container.container-fluid .container-content{max-width:100%}.col{text-align:left;display:inline-block}.row.gutters>tbody>tr>td,.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td{padding-left:10px;padding-right:10px}.col-1{width:8.33%!important;max-width:8.33%!important}.col-2{width:16.66%!important;max-width:16.66%!important}.col-3{width:25%!important;max-width:25%!important}.col-4{width:33.33%!important;max-width:33.33%!important}.col-5{width:41.66%!important;max-width:41.66%!important}.col-6{width:50%!important;max-width:50%!important}.col-7{width:58.33%!important;max-width:58.33%!important}.col-8{width:66.66%!important;max-width:66.66%!important}.col-9{width:75%!important;max-width:75%!important}.col-10{width:83.33%!important;max-width:83.33%!important}.col-11{width:91.66%!important;max-width:91.66%!important}.col-12,.img-fluid{max-width:100%!important}.col-12{width:100%!important}.btn.text-left .btn-content,.row.h-align-left>tbody>tr>td,.text-left{text-align:left!important}.btn.text-center .btn-content,.row.h-align-center>tbody>tr>td,.text-center{text-align:center!important}.btn.text-right .btn-content,.row.h-align-right>tbody>tr>td,.text-right{text-align:right!important}.row.v-align-top>tbody>tr>td>.col{vertical-align:top!important}.row.v-align-middle>tbody>tr>td>.col{vertical-align:middle!important}.row.v-align-bottom>tbody>tr>td>.col{vertical-align:bottom!important}.d-inline{display:inline}.d-inline-block{display:inline-block}.d-block,.navbar .navbar-toggle label .toggle-close .icon,.navbar .navbar-toggle label .toggle-open .icon{display:block}.d-table{display:table}.img-rounded{border-radius:8px!important}.img-fluid{display:block;height:auto}.visible-inline{display:inline!important}.visible-inline-block{display:inline-block!important}.visible-table{display:table!important}.visible-block{display:block!important}.hidden,.navbar .navbar-checkbox{display:none!important}.btn.text-justify .btn-content,.text-justify{text-align:justify!important}.btn .btn-content{padding:10px 20px;border:none;cursor:pointer;vertical-align:middle;font-weight:800}table.btn{border-collapse:separate!important}.btn.btn-lg .btn-content{padding:14px 32px}.btn.btn-sm .btn-content{padding:7px 14px}.btn.btn-sm .btn-content a{font-size:87.5%}.btn.btn-rect .btn-content{border-radius:0}.btn.btn-rounded .btn-content{border-radius:6px}.btn.btn-lg.btn-rounded .btn-content{border-radius:8px}.btn.btn-pill .btn-content{border-radius:100px}.btn .btn-content>a{color:#fff}.btn-primary .btn-content{background-color:var(--primary)}.btn-secondary .btn-content{background-color:var(--secondary)}.btn-success .btn-content{background-color:var(--success)}.btn-info .btn-content{background-color:var(--info)}.btn-warning .btn-content{background-color:var(--warning)}.btn-danger .btn-content{background-color:var(--danger)}.btn-light .btn-content{background-color:var(--light)}.btn-dark .btn-content,.navbar.navbar-dark,.table-dark{background-color:var(--dark)}.btn-light .btn-content>a{color:#212529}.btn-outline-primary .btn-content{border:1px solid var(--primary)}.btn-outline-primary .btn-content>a{color:var(--primary)}.btn-outline-secondary .btn-content{border:1px solid var(--secondary)}.btn-outline-secondary .btn-content>a{color:var(--secondary)}.btn-outline-success .btn-content{border:1px solid var(--success)}.btn-outline-success .btn-content>a{color:var(--success)}.btn-outline-info .btn-content{border:1px solid var(--info)}.btn-outline-info .btn-content>a{color:var(--info)}.btn-outline-warning .btn-content{border:1px solid var(--warning)}.btn-outline-warning .btn-content>a{color:var(--warning)}.btn-outline-danger .btn-content{border:1px solid var(--danger)}.btn-outline-danger .btn-content>a{color:var(--danger)}.btn-outline-light .btn-content{border:1px solid var(--light)}.btn-outline-light .btn-content>a,.navbar.navbar-dark .nav .nav-item a,.navbar.navbar-dark .navbar-toggle .toggle-close,.navbar.navbar-dark .navbar-toggle .toggle-open,.navbar.navbar-dark .navbar-toggle a.navbar-brand{color:var(--light)}.btn-outline-dark .btn-content{border:1px solid var(--dark)}.btn-outline-dark .btn-content>a,.navbar .nav .nav-item a,.navbar .navbar-toggle .toggle-close,.navbar .navbar-toggle .toggle-open,.navbar .navbar-toggle a.navbar-brand{color:var(--dark)}.btn-link .btn-content>a,.btn-outline-link .btn-content>a{color:#007bff}.table{--table-border-color:var(--gray-light)}.table.table-dark{--table-border-color:var(--gray-dark)}table.table{width:100%;margin-bottom:16px}.table td,.table th{padding:2px;vertical-align:middle;border-top:1px solid var(--table-border-color)}.table thead th{vertical-align:bottom;border-bottom:2px solid var(--table-border-color)}.table tbody+tbody{border-top:2px solid var(--table-border-color)}.table-bordered,.table-bordered td,.table-bordered th{border:1px solid var(--table-border-color)}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:#f2f2f2}.table-borderless tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0;border-top:0;border-bottom:0}.table-dark{color:var(--light)!important}.nav .nav-item{display:inline-block;padding:15px 20px}.navbar{background-color:var(--gray-light);max-width:800px;margin:0 auto}.navbar.navbar-fluid{max-width:none}.navbar .navbar-toggle label{display:block;cursor:pointer;user-select:none;text-align:left;text-decoration:none;line-height:30px}.navbar .navbar-content{padding:0 0 0 20px}.navbar .navbar-toggle a.navbar-brand{font-weight:700;white-space:nowrap}.navbar .navbar-toggle label .toggle-close,.navbar .navbar-toggle label .toggle-open{display:none;float:right;font-size:30px}.accordion{border:1px solid #ccc;border-bottom:none}.accordion-item-body,.accordion-item-heading{width:100%;border-bottom:1px solid #ccc}.accordion-checkbox,.accordion-item-heading .accordion-item-button{display:none}.accordion-item-heading{cursor:pointer;touch-action:manipulation;user-select:none;background-color:#f7f7f7}.accordion-item-heading .accordion-item-title{width:100%;padding:15px}.accordion-item-body>tbody>tr>td{padding:15px}@media only screen and (max-width:575px){.col-sm-1{width:8.33%!important;max-width:8.33%!important}.col-sm-2{width:16.66%!important;max-width:16.66%!important}.col-sm-3{width:25%!important;max-width:25%!important}.col-sm-4{width:33.33%!important;max-width:33.33%!important}.col-sm-5{width:41.66%!important;max-width:41.66%!important}.col-sm-6{width:50%!important;max-width:50%!important}.col-sm-7{width:58.33%!important;max-width:58.33%!important}.col-sm-8{width:66.66%!important;max-width:66.66%!important}.col-sm-9{width:75%!important;max-width:75%!important}.col-sm-10{width:83.33%!important;max-width:83.33%!important}.col-sm-11{width:91.66%!important;max-width:91.66%!important}.col-sm-12,.navbar .collapse{width:100%!important}.col-sm-12{max-width:100%!important}.visible-sm-inline{display:inline!important}.visible-sm-inline-block{display:inline-block!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,.visible-sm-table{display:table!important}.navbar .collapse .nav-td,.navbar .collapse .toggle-td,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,.visible-sm-block{display:block!important}.hidden-sm,.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close{display:none!important}.navbar.navbar-collapse .navbar-toggle label,.text-sm-left{text-align:left!important}.navbar .navbar-toggle label,.text-sm-center{text-align:center!important}.text-sm-right{text-align:right!important}.text-sm-justify{text-align:justify!important}.navbar .navbar-content{padding-top:12px!important;padding-left:0!important}.navbar-collapse .navbar-content{padding:12px 20px!important}.navbar.navbar-collapse .nav .nav-item{text-align:left!important;padding-left:0!important}.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,.navbar-collapse .navbar-checkbox~.collapse .toggle-td{padding-bottom:5px!important}.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item{display:block!important;text-align:left!important;padding:12px 0!important}.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td{padding-bottom:0!important}}@media only screen and (min-width:0){.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button{display:table-cell!important;padding:15px!important;vertical-align:middle!important;font-size:20px!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,.accordion-checkbox[type=checkbox]~.accordion-item-body,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less{display:none!important}.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more{display:block!important}}
.visible-outlook{display:none!important}.unstyle-auto-detected-links a,a[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
</style>
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="https://satech-migrate.org/images/logo-app.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo-app.png"
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
<table class="table table-borderless" border="0" cellpadding="0"
cellspacing="0">
<thead>
<tr></tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
<td style="font-size: 12px;font-family: \'Roboto\';width: 110.062px;"
width="110.062">No. de requisición</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
G-SG-2025-0003</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Gerencia</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Gerencia de Servicios Generales y Almacén</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha solicitada
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Proyecto</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
NP-047/24-NP-047/24-Estudio Transferencia de Calor-MONOBOYAS DN-001/24</td>
<td style="font-size: 12px;font-family: \'Roboto\';">Fecha requerida
</td>
<td
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
25-01-2025</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Solicitante</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';">Lugar de entrega
</td>
<td colspan="3"
style="font-size: 12px;font-family: \'Roboto\';font-weight: bold;color: var(--dark);">
Ullam praesentium au</td>
</tr>
<tr>

</tr>
<tr></tr>
</tbody>
</table>

<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
PARTIDAS</th>
</tr>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 27.609px;"
width="27.609">Código</td>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;padding: 5px;margin: 0;"
width="74.406">Unidad</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;font-weight: bold;width: 56.047px;"
width="56.047">Cantidad</td>
</tr>
</thead>
<tbody>
<tr>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
GCN0070038</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Reten Viton Sfk 17379</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Pz</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
1</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="4"
style="color: #162d4d;font-weight: bold;font-size: 14px;text-transform: uppercase;">
Observaciones de las partidas</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;width: 68.547px;font-weight: bold;color: var(--dark);"
width="68.547">Partida 1</td>
<td
style="font-size: 12px;font-family: Roboto, sans-serif;">
Sin observaciones</td>
</tr>
</tbody>
</table>
<table class="table table-bordered" border="0" cellpadding="0"
cellspacing="0" style="border-radius: 6px;">
<thead>
<tr>
<th colspan="2"
style="color: #162d4d;font-weight: bold;font-size: 14px;">
OBSERVACIONES O NOTAS</th>
</tr>
</thead>
<tbody>
<tr>
<td style="font-family: Roboto, sans-serif;color: #5b6c82;">
<p class="text-justify" style="font-size: 12px;">
Sin observaciones</p>
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
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-25 04:34:04',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-25 04:34:04',
                'updated_at' => '2025-01-25 04:34:04',
            ),
            23 =>
            array(
                'id' => 24,
                'uuid' => '67b53bd1-ce9b-45cd-bc0b-ff5e301aea10',
                'mailer' => 'smtp',
                'stream_id' => NULL,
                'mail_class' => NULL,
                'subject' => 'Alta de producto/servicio',
                'from' => '{"noreply@satechenergy.com": "SA-TECH"}',
                'reply_to' => NULL,
                'to' => '{"ahernandezm@gptservices.com": null}',
                'cc' => NULL,
                'bcc' => NULL,
                'html' => '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title></title>
<link rel="stylesheet" href="assets/css/framework.min.css">
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
<style type="text/css">
a {
text-decoration: none;
}
</style>
<!--[if mso]>
<xml>
<o:OfficeDocumentSettings>
<o:AllowPNG/>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>

<style type="text/css">
.col, div.col { width:100% !important; max-width:100% !important; }
.hidden-outlook, .hidden-outlook table {
display:none !important;
mso-hide:all !important;
}

* {
font-family: sans-serif !important;
-ms-text-size-adjust: 100%;
}

img {
-ms-interpolation-mode:bicubic;
}

td.body-content {
width: 680px;
}

td.row-content {
font-size:0;
}
</style>
<![endif]-->
<!--[if !mso]><!-->
<style type="text/css">
.visible-outlook {
display: none !important;
}

a[x-apple-data-detectors],
.unstyle-auto-detected-links a {
border-bottom: 0 !important;
cursor: default !important;
color: inherit !important;
text-decoration: none !important;
font-size: inherit !important;
font-family: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
}

body,
html {
margin: 0 auto;
padding: 0;
width: 100%;
height: 100%;
background-color: #fff
}

.body-content {
--primary: #0a6fe4;
--secondary: #6c757d;
--success: #28a745;
--info: #17a2b8;
--warning: #ffc107;
--danger: #dc3545;
--light: #f8f9fa;
--dark: #343a40;
--gray-light: #dee2e6;
--gray-dark: #6c6c6c;
font-size: 16px;
font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;
color: #212529;
font-weight: 400;
line-height: 1.45;
text-align: left;
-webkit-text-size-adjust: 100%;
-ms-text-size-adjust: 100%
}

a {
text-decoration: none;
color: var(--primary)
}

p {
margin: 0 0 10px;
mso-line-height-rule: exactly
}

h1,
h2,
h3,
h4,
h5,
h6 {
font-weight: 700;
margin: 0 0 10px;
mso-line-height-rule: exactly
}

h1 {
font-size: 175%
}

h2 {
font-size: 150%
}

h3 {
font-size: 135%
}

.btn.btn-lg .btn-content a,
h4 {
font-size: 125%
}

h5 {
font-size: 112.5%
}

h6 {
font-size: 100%
}

table {
border-collapse: collapse
}

img.icon,
svg.icon {
width: 1em;
height: 1em
}

code {
background-color: #eee;
padding: 2px;
font-size: 90%
}

blockquote {
margin: 0 0 10px;
border-left: 3px solid #ddd;
padding: 12px 5px 12px 16px;
background-color: #fafafa
}

blockquote p:last-child {
margin-bottom: 0
}

.btn.btn-block,
.navbar .collapse.collapse-right,
.row {
width: 100%
}

.row>tbody>tr>td {
text-align: center;
vertical-align: top
}

.container {
width: 100%;
max-width: 680px;
margin: 0 auto
}

.container-content {
padding: 0;
vertical-align: top;
max-width: 680px
}

.container.container-lg,
.container.container-lg .container-content {
max-width: 800px
}

.container.container-fluid,
.container.container-fluid .container-content {
max-width: 100%
}

.col {
text-align: left;
display: inline-block;
vertical-align: top;
width: 100%
}

.col-table {
width: 100%;
vertical-align: top
}

.col-content,
.nav {
vertical-align: top
}

.row.gutters>tbody>tr>td,
.row.gutters>tbody>tr>td>.col>.col-table>tbody>tr>td {
padding-left: 10px;
padding-right: 10px
}

.col-1 {
width: 8.33% !important;
max-width: 8.33% !important
}

.col-2 {
width: 16.66% !important;
max-width: 16.66% !important
}

.col-3 {
width: 25% !important;
max-width: 25% !important
}

.col-4 {
width: 33.33% !important;
max-width: 33.33% !important
}

.col-5 {
width: 41.66% !important;
max-width: 41.66% !important
}

.col-6 {
width: 50% !important;
max-width: 50% !important
}

.col-7 {
width: 58.33% !important;
max-width: 58.33% !important
}

.col-8 {
width: 66.66% !important;
max-width: 66.66% !important
}

.col-9 {
width: 75% !important;
max-width: 75% !important
}

.col-10 {
width: 83.33% !important;
max-width: 83.33% !important
}

.col-11 {
width: 91.66% !important;
max-width: 91.66% !important
}

.col-12 {
width: 100% !important;
max-width: 100% !important
}

.btn.text-left .btn-content,
.row.h-align-left>tbody>tr>td,
.text-left {
text-align: left !important
}

.btn.text-center .btn-content,
.row.h-align-center>tbody>tr>td,
.text-center {
text-align: center !important
}

.btn.text-right .btn-content,
.row.h-align-right>tbody>tr>td,
.text-right {
text-align: right !important
}

.row.v-align-top>tbody>tr>td>.col {
vertical-align: top !important
}

.row.v-align-middle>tbody>tr>td>.col {
vertical-align: middle !important
}

.row.v-align-bottom>tbody>tr>td>.col {
vertical-align: bottom !important
}

.d-inline {
display: inline
}

.d-inline-block {
display: inline-block
}

.d-block,
.navbar .navbar-toggle label .toggle-close .icon,
.navbar .navbar-toggle label .toggle-open .icon {
display: block
}

.d-table {
display: table
}

.img-rounded {
border-radius: 8px !important
}

.img-fluid {
max-width: 100% !important;
display: block;
height: auto
}

.visible-inline {
display: inline !important
}

.visible-inline-block {
display: inline-block !important
}

.visible-table {
display: table !important
}

.visible-block {
display: block !important
}

.hidden,
.navbar .navbar-checkbox {
display: none !important
}

.btn.text-justify .btn-content,
.text-justify {
text-align: justify !important
}

.btn .btn-content {
padding: 10px 20px;
border: none;
cursor: pointer;
text-align: center;
vertical-align: middle;
font-weight: 800
}

table.btn {
border-collapse: separate !important
}

.btn.btn-lg .btn-content {
padding: 14px 32px
}

.btn.btn-sm .btn-content {
padding: 7px 14px
}

.btn.btn-sm .btn-content a {
font-size: 87.5%
}

.btn.btn-rect .btn-content {
border-radius: 0
}

.btn.btn-rounded .btn-content {
border-radius: 6px
}

.btn.btn-lg.btn-rounded .btn-content {
border-radius: 8px
}

.btn.btn-pill .btn-content {
border-radius: 100px
}

.btn .btn-content>a {
color: #fff
}

.btn-primary .btn-content {
background-color: var(--primary)
}

.btn-secondary .btn-content {
background-color: var(--secondary)
}

.btn-success .btn-content {
background-color: var(--success)
}

.btn-info .btn-content {
background-color: var(--info)
}

.btn-warning .btn-content {
background-color: var(--warning)
}

.btn-danger .btn-content {
background-color: var(--danger)
}

.btn-light .btn-content {
background-color: var(--light)
}

.btn-light .btn-content>a {
color: #212529
}

.btn-dark .btn-content,
.navbar.navbar-dark {
background-color: var(--dark)
}

.btn-outline-primary .btn-content {
border: 1px solid var(--primary)
}

.btn-outline-primary .btn-content>a {
color: var(--primary)
}

.btn-outline-secondary .btn-content {
border: 1px solid var(--secondary)
}

.btn-outline-secondary .btn-content>a {
color: var(--secondary)
}

.btn-outline-success .btn-content {
border: 1px solid var(--success)
}

.btn-outline-success .btn-content>a {
color: var(--success)
}

.btn-outline-info .btn-content {
border: 1px solid var(--info)
}

.btn-outline-info .btn-content>a {
color: var(--info)
}

.btn-outline-warning .btn-content {
border: 1px solid var(--warning)
}

.btn-outline-warning .btn-content>a {
color: var(--warning)
}

.btn-outline-danger .btn-content {
border: 1px solid var(--danger)
}

.btn-outline-danger .btn-content>a {
color: var(--danger)
}

.btn-outline-light .btn-content {
border: 1px solid var(--light)
}

.btn-outline-light .btn-content>a,
.navbar.navbar-dark .nav .nav-item a,
.navbar.navbar-dark .navbar-toggle .toggle-close,
.navbar.navbar-dark .navbar-toggle .toggle-open,
.navbar.navbar-dark .navbar-toggle a.navbar-brand {
color: var(--light)
}

.btn-outline-dark .btn-content {
border: 1px solid var(--dark)
}

.btn-outline-dark .btn-content>a,
.navbar .nav .nav-item a,
.navbar .navbar-toggle .toggle-close,
.navbar .navbar-toggle .toggle-open,
.navbar .navbar-toggle a.navbar-brand {
color: var(--dark)
}

.btn-link .btn-content>a,
.btn-outline-link .btn-content>a {
color: #007bff
}

.table {
--table-border-color: var(--gray-light)
}

.table.table-dark {
--table-border-color: var(--gray-dark)
}

table.table {
width: 100%;
margin-bottom: 16px
}

.table td,
.table th {
padding: 12px;
vertical-align: middle;
border-top: 1px solid var(--table-border-color)
}

.table thead th {
vertical-align: bottom;
border-bottom: 2px solid var(--table-border-color)
}

.table tbody+tbody {
border-top: 2px solid var(--table-border-color)
}

.table-bordered,
.table-bordered td,
.table-bordered th {
border: 1px solid var(--table-border-color)
}

.table-bordered thead td,
.table-bordered thead th {
border-bottom-width: 2px
}

.table-striped tbody tr:nth-of-type(odd) {
background-color: #f2f2f2
}

.table-borderless tbody,
.table-borderless td,
.table-borderless th,
.table-borderless thead th {
border: 0;
border-top: 0;
border-bottom: 0
}

.table-dark {
color: var(--light) !important;
background-color: var(--dark)
}

.nav .nav-item {
display: inline-block;
padding: 15px 20px;
text-align: center
}

.navbar {
vertical-align: top;
background-color: var(--gray-light);
max-width: 800px;
margin: 0 auto
}

.navbar.navbar-fluid {
max-width: none
}

.navbar .navbar-toggle label {
display: block;
cursor: pointer;
user-select: none;
text-align: left;
text-decoration: none;
line-height: 30px
}

.navbar .navbar-content {
padding: 0 0 0 20px
}

.navbar .navbar-toggle a.navbar-brand {
font-weight: 700;
white-space: nowrap
}

.navbar .navbar-toggle label .toggle-close,
.navbar .navbar-toggle label .toggle-open {
display: none;
float: right;
font-size: 30px
}

.accordion {
border: 1px solid #ccc;
border-bottom: none
}

.accordion-item-body,
.accordion-item-heading {
width: 100%;
border-bottom: 1px solid #ccc
}

.accordion-checkbox,
.accordion-item-heading .accordion-item-button {
display: none
}

.accordion-item-heading {
cursor: pointer;
touch-action: manipulation;
user-select: none;
background-color: #f7f7f7
}

.accordion-item-heading .accordion-item-title {
width: 100%;
padding: 15px
}

.accordion-item-body>tbody>tr>td {
padding: 15px
}

@media only screen and (max-width:575px) {
.col-sm-1 {
width: 8.33% !important;
max-width: 8.33% !important
}

.col-sm-2 {
width: 16.66% !important;
max-width: 16.66% !important
}

.col-sm-3 {
width: 25% !important;
max-width: 25% !important
}

.col-sm-4 {
width: 33.33% !important;
max-width: 33.33% !important
}

.col-sm-5 {
width: 41.66% !important;
max-width: 41.66% !important
}

.col-sm-6 {
width: 50% !important;
max-width: 50% !important
}

.col-sm-7 {
width: 58.33% !important;
max-width: 58.33% !important
}

.col-sm-8 {
width: 66.66% !important;
max-width: 66.66% !important
}

.col-sm-9 {
width: 75% !important;
max-width: 75% !important
}

.col-sm-10 {
width: 83.33% !important;
max-width: 83.33% !important
}

.col-sm-11 {
width: 91.66% !important;
max-width: 91.66% !important
}

.col-sm-12 {
width: 100% !important;
max-width: 100% !important
}

.visible-sm-inline {
display: inline !important
}

.visible-sm-inline-block {
display: inline-block !important
}

.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-nav,
.visible-sm-table {
display: table !important
}

.navbar .collapse .nav-td,
.navbar .collapse .toggle-td,
.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-close,
.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-open,
.visible-sm-block {
display: block !important
}

.hidden-sm,
.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .navbar-toggle .toggle-open,
.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-nav,
.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .navbar-toggle .toggle-close {
display: none !important
}

.navbar.navbar-collapse .navbar-toggle label,
.text-sm-left {
text-align: left !important
}

.navbar .navbar-toggle label,
.text-sm-center {
text-align: center !important
}

.text-sm-right {
text-align: right !important
}

.text-sm-justify {
text-align: justify !important
}

.navbar .collapse {
width: 100% !important
}

.navbar .navbar-content {
padding-top: 12px !important;
padding-left: 0 !important
}

.navbar-collapse .navbar-content {
padding: 12px 20px !important
}

.navbar.navbar-collapse .nav .nav-item {
text-align: left !important;
padding-left: 0 !important
}

.navbar-collapse .navbar-checkbox[type=checkbox]:checked~.collapse .toggle-td,
.navbar-collapse .navbar-checkbox~.collapse .toggle-td {
padding-bottom: 5px !important
}

.navbar-collapse .navbar-checkbox~.collapse .navbar-nav .nav-item {
display: block !important;
text-align: left !important;
padding: 12px 0 !important
}

.navbar-collapse .navbar-checkbox[type=checkbox]~.collapse .toggle-td {
padding-bottom: 0 !important
}
}

@media only screen and (min-width:0) {
.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-item-button {
display: table-cell !important;
padding: 15px !important;
vertical-align: middle !important;
font-size: 20px !important
}

.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-more,
.accordion-checkbox[type=checkbox]~.accordion-item-body,
.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-less {
display: none !important
}

.accordion-checkbox[type=checkbox]:checked~.accordion-item-body,
.accordion-checkbox[type=checkbox]:checked~.accordion-item-heading .accordion-less,
.accordion-checkbox[type=checkbox]~.accordion-item-heading .accordion-more {
display: block !important
}
}
</style>
<!--<![endif]-->
<!--[if !mso]><!-->
<link rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Roboto:400,500,500i,700,700i,900&amp;display=swap">
<!--<![endif]-->
</head>

<body style="background-color: #dae6f7;">
<table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #dae6f7;">
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
role="presentation">
<tbody>
<tr>
<td class="container-content"
style="border-radius: 10px;background-color: #ffffff;padding-top: 30px;padding-right: 20px;padding-bottom: 30px;padding-left: 20px;border-width: 1px;border-color: var(--gray-light);">
<center>
<!--[if mso]><img class="img-fluid" src="assets/img/logotipo_GPT.png" style="width: 174px;" width="174"><![endif]--><!--[if !mso]><!--><img
class="img-fluid" src="https://satech-migrate.org/images/logo/logotipo_GPT.png"
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
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Estatus</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);text-transform: capitalize;">
pendiente</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Compañía</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
GPT Ingeniería Y Manufactura, S.A. de C.V.</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: \'Roboto\';width: 48.906px;"
width="48.906">Solicitante</td>
<td
style="font-size: 12px;font-family: \'Roboto\';text-align: left;font-weight: bold;color: var(--dark);">
Alan Etzahu Hernández Mendoza</td>
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
cellspacing="0" style="border-radius: 6px;">
<tbody>
<tr>
<td class="text-center"
style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
Producto/Servicio</td>
<td class="text-center"
style="font-family: Roboto, sans-serif;color: var(--dark);font-size: 12px;padding: 12px;font-weight: bold;width: 74.406px;"
width="74.406">Unidad</td>
</tr>
<tr>
<td style="font-size: 12px;font-family: Roboto, sans-serif;">
test</td>
<td style="font-size: 12px;font-family: Roboto, sans-serif;">
Botella</td>
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
cellpadding="0" cellspacing="0" role="presentation">
<tbody>
<tr>
<td class="btn-content"><a href="https://app.gptsatech.com">VER
SOLICITUD</a></td>
</tr>
</tbody>
</table>
</center>
</td>
</tr>
</tbody>
</table>
<center><small style="color: var(--dark);font-size: 12px;"> Notificación generada
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
',
                'text' => NULL,
                'opens' => 0,
                'clicks' => 0,
                'sent_at' => '2025-01-26 05:06:53',
                'resent_at' => NULL,
                'accepted_at' => NULL,
                'delivered_at' => NULL,
                'last_opened_at' => NULL,
                'last_clicked_at' => NULL,
                'complained_at' => NULL,
                'soft_bounced_at' => NULL,
                'hard_bounced_at' => NULL,
                'unsubscribed_at' => NULL,
                'created_at' => '2025-01-26 05:06:53',
                'updated_at' => '2025-01-26 05:06:53',
            ),
        ));
    }
}
