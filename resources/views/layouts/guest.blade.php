<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Page Title' }} | {{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/beercss@3.2.13/dist/cdn/beer.min.css" rel="stylesheet">
    <script type="module" src="https://cdn.jsdelivr.net/npm/beercss@3.2.13/dist/cdn/beer.min.js"></script>
    <script type="module"
        src="https://cdn.jsdelivr.net/npm/material-dynamic-colors@1.0.1/dist/cdn/material-dynamic-colors.min.js"></script>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    @stack('styles')
    <livewire:styles />
</head>

<body class="light surface-variant">
    <main class="responsive">
        {{ $slot }}
        <footer class="center bottom surface-variant">
            <div class="small-divider"></div>
            <div class="center-align">&copy; Copyright <span class="bold">CV. Media Computindo</span>. All Rights
                Reserved</div>
        </footer>
    </main>
    <div class="toast" id="toast">
        <i>error</i>
        <span></span>
    </div>
    <script>
        window.addEventListener('showToast', event => {
            document.getElementById('toast').querySelector('span').innerHTML = event.detail.message;
            ui("#toast", 3000);
        })
    </script>
    @stack('scripts')
    <livewire:scripts />
</body>

</html>
