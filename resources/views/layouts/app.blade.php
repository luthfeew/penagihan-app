<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Page Title' }} | {{ config('app.name') }}</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/beercss@3.2.13/dist/cdn/beer.min.css" rel="stylesheet">
    <script type="module" src="https://cdn.jsdelivr.net/npm/beercss@3.2.13/dist/cdn/beer.min.js"></script>
    <script type="module"
        src="https://cdn.jsdelivr.net/npm/material-dynamic-colors@1.0.1/dist/cdn/material-dynamic-colors.min.js"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <livewire:styles />
</head>

<body class="light cyan">
    @include('layouts.navbar')
    <main class="responsive">
        <div class="space"></div>
        {{ $slot }}
    </main>
    <div class="toast" id="toast">
        <i>done</i>
        <span></span>
    </div>
    <script>
        window.addEventListener('showDialog', event => {
            document.getElementById(event.detail.id).show();
            document.getElementById(event.detail.id).scrollTo(0, 0);
        })
        window.addEventListener('closeDialog', event => {
            document.getElementById(event.detail.id).close();
        })
        window.addEventListener('showToast', event => {
            // document.getElementById('toast').querySelector('i').innerHTML = event.detail.icon;
            document.getElementById('toast').querySelector('span').innerHTML = event.detail.message;
            ui("#toast", 3000);
        })
        window.addEventListener('openNewTab', event => {
            window.open(event.detail.url, '_blank');
        })
    </script>
    @stack('scripts')
    <livewire:scripts />
</body>

</html>
