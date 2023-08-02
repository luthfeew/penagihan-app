<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Page Title' }} | {{ config('app.name') }}</title>
    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <livewire:styles />
</head>

<body class="light">
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
