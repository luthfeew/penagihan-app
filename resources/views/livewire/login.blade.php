<div class="large-height no-scroll middle-align center-align">
    <article>
        <h5 class="center-align">
            <i class="extra">router</i>
            {{ config('app.name') }}
        </h5>
        <div class="space"></div>
        <form wire:submit.prevent="authenticate">
            <x-input name="email" label="Email" />
            <x-input type="password" name="password" label="Password" />
            <button class="responsive border" type="submit">Login</button>
        </form>
    </article>
</div>
