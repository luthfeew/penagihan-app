<div class="large-height no-scroll middle-align center-align">
    <article class="large-elevate large-padding">
        {{-- <div class="row"> --}}
        <nav class="center-align">
            <img class="round" src="{{ asset('img/logo.png') }}">
            {{-- <div class="max"> --}}
            <h5>{{ config('app.name') }}</h5>
            {{-- </div> --}}
        </nav>
        {{-- </div> --}}
        <div class="space"></div>
        <form wire:submit.prevent="authenticate">
            <x-input name="username" label="Username" />
            <x-input type="password" name="password" label="Password" />
            <button class="responsive cyan" type="submit">
                <i>login</i>
                <span>Masuk</span>
            </button>
        </form>
    </article>
</div>
