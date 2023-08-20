<nav class="left m l large-elevate">
    <div class="medium-space"></div>
    <div class="medium-space"></div>
    {{-- <img class="round" src="{{ asset('img/logo.png') }}"> --}}
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
    <a href="/perawatan" class="{{ request()->is('perawatan') ? 'active' : '' }}">
        <i>engineering</i>
        <div>Perawatan</div>
    </a>
    <a href="/pelanggan" class="{{ request()->is('pelanggan') ? 'active' : '' }}">
        <i>group</i>
        <div>Pelanggan</div>
    </a>
    <a href="/pengaturan" class="{{ request()->is('pengaturan') ? 'active' : '' }}">
        <i>settings</i>
        <div>Pengaturan</div>
    </a>
    {{-- <a href="/akun" class="{{ request()->is('akun') ? 'active' : '' }}">
        <i>person</i>
        <div>Akun</div>
    </a> --}}
    <a href="/logout" class="{{ request()->is('logout') ? 'active' : '' }}">
        <i>logout</i>
        <div>Logout</div>
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
    {{-- <a href="/pengaturan" class="{{ request()->is('pengaturan') ? 'active' : '' }}">
        <i>settings</i>
        <div>Pengaturan</div>
    </a> --}}
    <a onclick="ui('#nav-drawer')">
        <i>more_vert</i>
        <div>Lainnya</div>
    </a>
</nav>

{{-- <header class="responsive fixed cyan large-elevate">
    <nav>
        <h5 class="max">
            <div class="s">Manajemen Tagihan</div>
            <div class="m l">Manajemen Tagihan {{ config('app.name') }}</div>
        </h5>
    </nav>
</header> --}}

<nav class="top medium-elevate">
    <img class="round small-margin" src="{{ asset('img/logo.png') }}">
    <h5 class="max bold">{{ config('app.name') }}</h5>
</nav>

{{-- <nav class="top">
    <button class="circle large transparent small-margin" onclick="ui('#nav-drawer')">
        <i>menu</i>
    </button>
    <h5 class="max">
        <div class="m l">Manajemen Tagihan {{ config('app.name') }}</div>
        <div class="s">{{ config('app.name') }}</div>
    </h5>
    <img class="round" src="{{ asset('img/logo.png') }}">
    <h5 class="small m l">CV. Media Computindo</h5>
</nav> --}}

<dialog class="left" id="nav-drawer">
    <header class="fixed">
        <nav>
            <button class="transparent circle large" onclick="ui('#nav-drawer')">
                <i>close</i>
            </button>
            <h5 class="max bold">{{ config('app.name') }}</h5>
        </nav>
    </header>
    <a href="/perawatan" class="row round">
        <i>engineering</i>
        <span>Perawatan</span>
    </a>
    <a href="/pengaturan" class="row round">
        <i>settings</i>
        <span>Pengaturan</span>
    </a>
    {{-- <a href="/akun" class="row round">
        <i>person</i>
        <span>Akun</span>
    </a> --}}
    <a href="/logout" class="row round">
        <i>logout</i>
        <span>Logout</span>
    </a>
</dialog>
