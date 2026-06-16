@props(['src', 'poster' => null, 'title' => null, 'type' => 'video/mp4'])

@pushOnce('filament-styles')
    @vite('resources/js/video-player.js')
@endPushOnce

<div class="w-full">
    @if ($title)
        <h3 class="mb-2 text-base font-semibold text-gray-700">{{ $title }}</h3>
    @endif

    <video id="video-{{ md5($src) }}" class="video-js vjs-big-play-centered" controls preload="auto"
        @if ($poster) poster="{{ $poster }}" @endif data-setup="{}">
        <source src="{{ $src }}" type="{{ $type }}">
        <p class="vjs-no-js">
            Para ver este video, activa JavaScript o usa un navegador compatible con
            <a href="https://videojs.com/html5-video-support/" target="_blank">HTML5 video</a>.
        </p>
    </video>
</div>
