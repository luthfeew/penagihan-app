<div>
    <article class="large-elevate large-padding">
        <div class="grid">
            <div class="s12 m6 l3">
                <div class="field label suffix border">
                    <select wire:model="rentang" class="active">
                        <option value="semua">Semua</option>
                        <option value="custom">Custom</option>
                    </select>
                    <label class="active">Rentang Waktu</label>
                    <i>arrow_drop_down</i>
                </div>
            </div>
            @if ($rentang == 'custom')
                <div class="s12 m6 l3">
                    <div class="field label suffix border">
                        <select wire:model="bulan" class="active">
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <label class="active">Bulan</label>
                        <i>arrow_drop_down</i>
                    </div>
                </div>
                <div class="s12 m6 l3">
                    <div class="field label suffix border">
                        <select wire:model="tahun" class="active">
                            @for ($i = 2023; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <label class="active">Tahun</label>
                        <i>arrow_drop_down</i>
                    </div>
                </div>
            @else
                <div class="s12 m6 l3 m l"></div>
                <div class="s12 m6 l3 m l"></div>
            @endif
            <div class="s12 m6 l3 m l"></div>
            <div class="s12 m6 l3">
                <article class="border green2">
                    <div class="row">
                        <i class="extra">done</i>
                        <div class="max">
                            <h5 class="bold">{{ $lunas }}</h5>
                            <p class="bold">Lunas Bayar</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s12 m6 l3">
                <article class="border red2">
                    <div class="row">
                        <i class="extra">block</i>
                        <div class="max">
                            <h5 class="bold">{{ $belumLunas }}</h5>
                            <p class="bold">Belum Bayar</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s12 m6 l3">
                <article class="border blue2">
                    <div class="row">
                        <i class="extra">person</i>
                        <div class="max">
                            <h5 class="bold">{{ $pelanggan }}</h5>
                            <p class="bold">Pelanggan</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s12 m6 l3">
                <article class="border blue2">
                    <div class="row">
                        <i class="extra">person_add</i>
                        <div class="max">
                            <h5 class="bold">{{ $pelangganBaru }}</h5>
                            <p class="bold">Pelanggan Baru</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s12 m6 l3">
                <article class="border green2">
                    <div class="row">
                        <i class="extra">attach_money</i>
                        <div class="max">
                            <h5 class="small bold">@rupiah($laba)</h5>
                            <p class="bold">Laba Kotor</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s12 m6 l3">
                <article class="border red2">
                    <div class="row">
                        <i class="extra">money_off</i>
                        <div class="max">
                            @php
                                $total = 0;
                                foreach ($tagihans as $tagihan) {
                                    $total += $tagihan->pelanggan->paket->tarif + $tagihan->pelanggan->biaya1 + $tagihan->pelanggan->biaya2 - $tagihan->pelanggan->diskon;
                                }
                            @endphp
                            <h5 class="small bold">@rupiah($total)</h5>
                            <p class="bold">Laba Tertahan</p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="s12 m6 l3">
                <article class="border green2">
                    <div class="row">
                        <i class="extra">attach_money</i>
                        <div class="max">
                            <h5 class="small bold">@rupiah($labaBersih)</h5>
                            <p class="bold">Laba Bersih</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        {{-- <hr>
        <div class="chart">
            <canvas id="lineChart" style="min-height: 250px; height: 400px; max-height: 450px; width: 100%;"></canvas>
        </div>


        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('lineChart');
            const bulan = [];
            const jumlah = [];
            @foreach ($chart as $c)
            @php
            switch($c->bbb)
            {
                case 1 : $namaBln = "Januari"; $hari=31;
                break;
                case 2 : $namaBln = "Pebruari"; $hari=28;
                break;
                case 3 : $namaBln = "Maret"; $hari=31;
                break;
                case 4 : $namaBln = "April";$hari=30;
                break;
                case 5 : $namaBln = "Mei";$hari=31;
                break;
                case 6 : $namaBln = "Juni"; $hari=30;
                break;
                case 7 : $namaBln = "Juli"; $hari=31;
                break;
                case 8 : $namaBln = "Agustus"; $hari=31;
                break;
                case 9 : $namaBln = "September";$hari =30;
                break;
                case 10: $namaBln = "Oktober"; $hari=31;
                break;
                case 11: $namaBln = "Nopember"; $hari=30;
                break;
                case 12: $namaBln = "Desember";$hari=31;
                break;
            }
            @endphp
                bulan.push('{{$namaBln}}');
                jumlah.push('{{$c->tag}}');
            @endforeach
            // ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"]

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: bulan,
                    datasets: [{
                        label: '# Laba',
                        data: jumlah,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        @endpush --}}


    </article>
</div>
