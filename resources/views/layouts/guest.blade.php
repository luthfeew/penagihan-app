<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Page Title' }} | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <livewire:styles />
</head>

<body class="light fill">
    <main class="responsive">
        {{ $slot }}
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
    <livewire:scripts />
</body>

</html>
