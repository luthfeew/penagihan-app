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
    {{-- <a href="/pengaduan" class="{{ request()->is('pengaduan') ? 'active' : '' }}">
        <i>build</i>
        <div>Pengaduan</div>
    </a> --}}
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
    {{-- <a href="/pengaduan" class="{{ request()->is('pengaduan') ? 'active' : '' }}">
        <i>build</i>
        <div>Pengaduan</div>
    </a> --}}
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
    <h5 class="max">{{ config('app.name') }}</h5>
    <img src="https://www.beercss.com/favicon.png" class="circle margin">
</nav>

{{-- BELUM FIX --}}
<dialog class="left" id="nav-drawer">
    <header class="fixed">
        <nav>
            <button class="transparent circle large" onclick="ui('#nav-drawer')">
                <i>close</i>
            </button>
            <h5 class="max">{{ config('app.name') }}</h5>
        </nav>
    </header>
    <a class="row round">
        <i>inbox</i>
        <span>Inbox</span>
        <div class="max"></div>
        <div>24</div>
    </a>
    <a class="row round">
        <i>send</i>
        <span>Outbox</span>
        <div class="max"></div>
        <div>100+</div>
    </a>
    <a class="row round">
        <i>favorite</i>
        <span>Favorities</span>
    </a>
    <a class="row round">
        <i>delete</i>
        <span>Trash</span>
    </a>
    <div class="small-divider"></div>
    <div class="row">Labels</div>
    <a class="row round">
        <i>fiber_manual_record</i>
        <span>Label</span>
    </a>
    <a class="row round">
        <i>change_history</i>
        <span>Label</span>
    </a>
    <a class="row round">
        <i>stop</i>
        <span>Label</span>
    </a>
</dialog>
