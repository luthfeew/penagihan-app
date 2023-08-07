<div>
    <div class="space"></div>
    <article>
        <div class="grid">
            <div class="s6 m3">
                <div class="field label suffix border">
                    <select class="active">
                        <option>Juli</option>
                    </select>
                    <label class="active">Bulan</label>
                    <i>arrow_drop_down</i>
                </div>
            </div>
            <div class="s6 m3">
                <div class="field label suffix border">
                    <select class="active">
                        <option>2023</option>
                    </select>
                    <label class="active">Tahun</label>
                    <i>arrow_drop_down</i>
                </div>
            </div>
            <div class="s12 m6"></div>


            <div class="s6 m3">
                <article class="border">
                    <div class="row">
                        <button class="border square round extra">
                            <i class="extra">person</i>
                        </button>
                        <div class="max">
                            <h5>{{ $pelanggans }}</h5>
                            <p>Pelanggan</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s6 m3">
                <article class="border">
                    <div class="row">
                        <button class="border square round extra">
                            <i class="extra">person_add</i>
                        </button>
                        <div class="max">
                            <h5>{{ $newPelanggans }}</h5>
                            <p>Pelanggan Baru</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s6 m3">
                <article class="border">
                    <div class="row">
                        <button class="border square round extra">
                            <i class="extra">paid</i>
                        </button>
                        <div class="max">
                            <h5>{{ $lunas }}</h5>
                            <p>Lunas Bayar</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s6 m3">
                <article class="border">
                    <div class="row">
                        <button class="border square round extra">
                            <i class="extra">money_off</i>
                        </button>
                        <div class="max">
                            <h5>{{ $belumLunas }}</h5>
                            <p>Belum Bayar</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </article>
</div>
