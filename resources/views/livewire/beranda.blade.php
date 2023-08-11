<div>
    <article class="large-elevate large-padding">
        <div class="grid">
            <div class="s12 m6 l3">
                <div class="field label suffix border">
                    <select wire:model="rentang" class="active">
                        <option value="1">Hari ini</option>
                        <option value="2">Kemarin</option>
                        <option value="3">7 Hari Terakhir</option>
                        <option value="4">30 Hari Terakhir</option>
                        <option value="5">Semua</option>
                    </select>
                    <label class="active">Rentang Waktu</label>
                    <i>arrow_drop_down</i>
                </div>
            </div>
            <div class="s12 m6 l3 m l"></div>
            <div class="s12 m6 l3 m l"></div>
            <div class="s12 m6 l3 m l"></div>
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
                            <p>Laba Tertahan</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </article>
</div>
