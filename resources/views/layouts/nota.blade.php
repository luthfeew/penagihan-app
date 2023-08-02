<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <livewire:styles />
</head>

<body class="light fill">
    <main class="responsive">
        {{ $slot }}
    </main>
    <livewire:scripts />
</body>

</html>
