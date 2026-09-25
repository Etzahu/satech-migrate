@php
    /**
     * Segundos hasta el próximo reintento. Con `--render` los pasa el propio comando;
     * sin él la vista la resuelve el manejador de excepciones y el dato viaja en la
     * cabecera Retry-After que fija PreventRequestsDuringMaintenance.
     */
    $retry = (int) ($retryAfter
        ?? ((($exception ?? null) instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface)
            ? ($exception->getHeaders()['Retry-After'] ?? 0)
            : 0));

    $code = '503';
    $state = 'Servicio en mantenimiento';
    $tone = 'live';
    $line = 'open';
@endphp
@extends('errors.layout')

@section('title', 'Servicio en mantenimiento')
@section('headline', 'La plataforma vuelve en unos minutos.')
@section('lede', 'Estamos aplicando una actualización programada. El acceso se restablece por sí solo; no necesita hacer nada.')

@section('status-extra')
    @if ($retry > 0)
        <div class="status__clock">
            <span class="status__label">Reintento automático</span>
            <span class="status__time mono" data-countdown="{{ $retry }}" aria-hidden="true">--:--</span>
        </div>
        <p class="sr-only">
            Esta página se recargará sola dentro de
            @if ($retry >= 60)
                {{ (int) ceil($retry / 60) }} minuto{{ ceil($retry / 60) == 1 ? '' : 's' }}.
            @else
                {{ $retry }} segundos.
            @endif
        </p>
        <div class="status__rule" style="--duration:{{ $retry }}s"></div>
    @endif
@endsection

@section('actions')
    <button type="button" class="btn" data-retry>
        Reintentar
        <span class="btn__progress" aria-hidden="true"></span>
    </button>
    <a class="quiet" href="mailto:ahernandezm@gptservices.com?subject=Mantenimiento%20SA-TECH">
        Escribir a soporte
    </a>
@endsection
