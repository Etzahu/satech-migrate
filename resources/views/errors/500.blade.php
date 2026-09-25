@php
    $code = '500';
    $state = 'Fallo del servidor';
    $tone = 'fault';
    $line = 'broken';
@endphp
@extends('errors.layout')

@section('title', 'Error del servidor')
@section('headline', 'Algo se rompió de nuestro lado.')
@section('lede', 'No pudimos completar su solicitud. El fallo queda registrado automáticamente; vuelva a intentarlo en unos minutos.')

@if (config('app.debug') && isset($exception))
    @section('trace')
        <div class="trace mono">
            <p class="trace__type">{{ get_class($exception) }}</p>
            <p class="trace__message">{{ $exception->getMessage() }}</p>
            <p class="trace__where">{{ $exception->getFile() }}:{{ $exception->getLine() }}</p>
        </div>
    @endsection
@endif
