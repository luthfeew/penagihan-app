<div>
    <article>
        <div class="grid">
            <div class="s12 m6 l3">
                <article class="border">
                    <div class="row">
                        <i class="extra">person</i>
                        <div class="max">
                            <h5>{{ $pelanggan }}</h5>
                            <p>Pelanggan</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s12 m6 l3">
                <article class="border">
                    <div class="row">
                        <i class="extra">person_add</i>
                        <div class="max">
                            <h5>{{ $pelangganBaru }}</h5>
                            <p>Pelanggan Baru</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s12 m6 l3">
                <article class="border">
                    <div class="row">
                        <i class="extra">done</i>
                        <div class="max">
                            <h5>{{ $lunas }}</h5>
                            <p>Lunas Bayar</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s12 m6 l3">
                <article class="border">
                    <div class="row">
                        <i class="extra">block</i>
                        <div class="max">
                            <h5>{{ $belumLunas }}</h5>
                            <p>Belum Bayar</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s12 m6 l3">
                <article class="border">
                    <div class="row">
                        <i class="extra">attach_money</i>
                        <div class="max">
                            <h5 class="small">@rupiah($laba)</h5>
                            <p>Laba</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s12 m6 l3">
                <article class="border">
                    <div class="row">
                        <i class="extra">money_off</i>
                        <div class="max">
                            @php
                                $total = 0;
                                foreach ($tagihans as $tagihan) {
                                    $total += $tagihan->pelanggan->paket->tarif + $tagihan->pelanggan->biaya1 + $tagihan->pelanggan->biaya2 - $tagihan->pelanggan->diskon;
                                }
                            @endphp
                            <h5 class="small">@rupiah($total)</h5>
                            <p>Laba Pending</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </article>
</div>
