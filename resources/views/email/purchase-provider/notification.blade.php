@extends('email.layouts.template')
@section('title-page', 'Proveedores')
@section('content')
    <table class="table table-bordered" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px;">
        <thead>
            <tr>
                <th colspan="4" style="color: #162d4d;font-weight: bold;font-size: 14px;">
                    Información</th>
            </tr>
            <tr>
                <td class="text-center"
                    style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);width: 150px;"
                    width="150">RFC</td>
                <td class="text-center"
                    style="font-size: 12px;font-family: Roboto, sans-serif;font-weight: bold;color: var(--dark);">
                    Nombre</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-size: 12px;font-family: Roboto, sans-serif;">
                    {{ $data['rfc'] }}</td>
                <td style="font-size: 12px;font-family: Roboto, sans-serif;">
                    {{ $data['name'] }}</td>
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
    <table class="btn btn-success btn-md btn-rounded" border="0" cellpadding="0" cellspacing="0" role="presentation">
        <tbody>
            <tr>
                <td class="btn-content"><a href="#">VER</a></td>
            </tr>
        </tbody>
    </table>
@endsection
