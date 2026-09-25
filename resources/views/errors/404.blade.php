@php
    $code = '404';
    $state = 'Recurso no encontrado';
    $tone = 'idle';
    $line = 'capped';
@endphp
@extends('errors.layout')

@section('title', 'Página no encontrada')
@section('headline', 'Esta página no existe.')
@section('lede', 'El enlace puede estar mal escrito, o el recurso pudo haberse movido o eliminado.')
