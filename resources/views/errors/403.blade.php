@php
    $code = '403';
    $state = 'Acceso restringido';
    $tone = 'idle';
    $line = 'closed';
@endphp
@extends('errors.layout')

@section('title', 'Acceso restringido')
@section('headline', 'No tiene permiso para ver esta página.')
@section('lede', 'Su cuenta no tiene acceso a este recurso. Si cree que debería tenerlo, escriba a soporte indicando qué intentaba abrir.')
