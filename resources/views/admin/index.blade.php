<div class="row mb-4">
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Users Registrasi</h4>
                    <h1>{{ $users ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Status Autentikasi</h4>
                    <h1>{{ $levels ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Data Jurusan</h4>
                    <h1>{{ $jurusans ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Data Kelas</h4>
                    <h1>{{ $kelas ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Data Pembina</h4>
                    <h1>{{ $pembinas ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Orang Tua</h4>
                    <h1>{{ $ortus ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Data Siswa</h4>
                    <h1>{{ $siswas ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Data Ekstrakurikuler</h4>
                    <h1>{{ $eskuls ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Jadwal Ekstrakurikuler</h4>
                    <h1>{{ $jadwals ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Dokumentasi</h4>
                    <h1>{{ $dokumentasis ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="mb-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Pendaftaran</h4>
                    <h1>{{ $pendaftarans ?? '0' }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Report Pendaftaran {{ date('Y') }}
            </div>
            <div class="card-body">
                <canvas id="viaPendaftaran"
                    style="min-height: 350px; height: 350px; max-height: 450px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('viaPendaftaran').getContext('2d');

        var chartData = {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            datasets: [{
                label: 'Pendaftaran per Bulan',
                data: @json($dataPendaftar),  // Mengambil data dari controller
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.1
            }]
        };

        var myChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
