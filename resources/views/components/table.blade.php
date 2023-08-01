<nav class="scroll">
    <table class="border">
        <thead>
            <tr>
                @foreach ($headers as $item)
                    <th>{{ $item }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</nav>
