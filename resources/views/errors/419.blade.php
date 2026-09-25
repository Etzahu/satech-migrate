@php
    $code = '419';
    $state = 'Sesión expirada';
    $tone = 'idle';
    $line = 'uncoupled';
@endphp
@extends('errors.layout')

@section('title', 'Sesión expirada')
@section('headline', 'Su sesión caducó por inactividad.')
@section('lede', 'Vuelva a iniciar sesión y repita la acción. Si estaba llenando un formulario, los datos no llegaron a enviarse.')

@section('actions')
    <a class="btn" href="{{ route('login') }}">Iniciar sesión</a>
    <a class="quiet" href="mailto:ahernandezm@gptservices.com?subject=Error%20419%20en%20SA-TECH">
        Escribir a soporte
    </a>
@endsection
