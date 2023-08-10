<nav class="left m l">
    <div class="medium-space"></div>
    <div class="space"></div>
    <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
        <i>home</i>
        <div>Beranda</div>
    </a>
    <a href="/transaksi" class="{{ request()->is('transaksi') ? 'active' : '' }}">
        <i>receipt_long</i>
        <div>Transaksi</div>
    </a>
    <a href="/bayar" class="{{ request()->is('bayar') ? 'active' : '' }}">
        <i>payments</i>
        <div>Bayar</div>
    </a>
    <a href="/pelanggan" class="{{ request()->is('pelanggan') ? 'active' : '' }}">
        <i>group</i>
        <div>Pelanggan</div>
    </a>
    <a href="/pengaturan" class="{{ request()->is('pengaturan') ? 'active' : '' }}">
        <i>settings</i>
        <div>Pengaturan</div>
    </a>
</nav>

<nav class="bottom s">
    <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
        <i>home</i>
        <div>Beranda</div>
    </a>
    <a href="/transaksi" class="{{ request()->is('transaksi') ? 'active' : '' }}">
        <i>receipt_long</i>
        <div>Transaksi</div>
    </a>
    <a href="/bayar" class="{{ request()->is('bayar') ? 'active' : '' }}">
        <i>payments</i>
        <div>Bayar</div>
    </a>
    <a href="/pelanggan" class="{{ request()->is('pelanggan') ? 'active' : '' }}">
        <i>group</i>
        <div>Pelanggan</div>
    </a>
    <a href="/pengaturan" class="{{ request()->is('pengaturan') ? 'active' : '' }}">
        <i>settings</i>
        <div>Pengaturan</div>
    </a>
</nav>

<nav class="top">
    <button class="circle large transparent small-margin" onclick="ui('#nav-drawer')">
        <i>menu</i>
    </button>
    <h5 class="max">
        <div class="m l">Manajemen Tagihan {{ config('app.name') }}</div>
        <div class="s">{{ config('app.name') }}</div>
    </h5>
    <img class="round" src="{{ asset('img/logo.png') }}">
    <h5 class="small m l">CV. Media Computindo</h5>
</nav>

<dialog class="left" id="nav-drawer">
    <header class="fixed">
        <nav>
            <button class="transparent circle large" onclick="ui('#nav-drawer')">
                <i>close</i>
            </button>
            <h5 class="max">{{ config('app.name') }}</h5>
        </nav>
    </header>
    {{-- <a class="row round">
        <i>person</i>
        <span>Akun</span>
    </a> --}}
    <a class="row round">
        <i>logout</i>
        <span>Logout</span>
    </a>
</dialog>
