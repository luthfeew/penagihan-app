<div>
    <div class="space"></div>
    <div class="grid">
        <div class="s12 m3"></div>
        <div class="s12 m6">
            <article>
                <div id="printableArea">
                    <nav class="center-align">
                        <i class="extra">router</i>
                        <h5>NET</h5>
                    </nav>
                    <div class="space"></div>
                    <div class="secondary-container no-round">
                        <p class="no-margin">Total Pembayaran</p>
                        <h5 class="small no-margin">{{ $paket }}</h5>
                        <h4 class="small no-margin">@rupiah($totalTagihan)</h4>
                    </div>
                    <div class="space"></div>
                    <p class="large-text">Rincian</p>
                    <div class="grid">
                        <div class="s6 middle-align">Nama Kepada</div>
                        <div class="s6 bold right-align">
                            {{ $nama }}<br>
                            {{ $telepon }}
                        </div>
                    </div>
                    <div class="small-divider"></div>
                    <div class="grid">
                        <div class="s6 middle-align">Iuran</div>
                        <div class="s6 bold right-align">@rupiah($iuran)</div>
                    </div>
                    <div class="small-divider"></div>
                    <div class="grid">
                        <div class="s6 middle-align">Biaya Tambahan</div>
                        <div class="s6 bold right-align">
                            {{ $tambahan1 }} @ @rupiah($biaya1)<br>
                            {{ $tambahan2 }} @ @rupiah($biaya2)
                        </div>
                    </div>
                    <div class="small-divider"></div>
                    <div class="grid">
                        <div class="s6 middle-align">Diskon</div>
                        <div class="s6 bold right-align">
                            @rupiah($diskon)
                        </div>
                    </div>
                    <div class="small-divider"></div>
                    <div class="grid">
                        <div class="s6 middle-align">Saldo Terpakai</div>
                        <div class="s6 bold right-align">
                            - @rupiah($iuran + $biaya1 + $biaya2 - $diskon - $totalTagihan)
                        </div>
                    </div>
                    <div class="small-divider"></div>
                    <div class="grid">
                        <div class="s6 middle-align">Bulan</div>
                        <div class="s6 bold right-align">
                            {{ $bulan }}
                        </div>
                    </div>
                    <div class="small-divider"></div>
                    <div class="grid">
                        <div class="s6 middle-align">Tanggal Bayar</div>
                        <div class="s6 bold right-align">
                            {{ $tanggal }}
                        </div>
                    </div>
                    <div class="small-divider"></div>
                    <div class="grid">
                        <div class="s6">Keterangan</div>
                        <div class="s6 bold right-align">L U N A S</div>
                    </div>
                </div>
            </article>
        </div>
        <div class="s12 m3"></div>
    </div>
</div>
