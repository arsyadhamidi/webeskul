@extends('admin.layout.master')

@section('content')
    <div class="row mb-4">
        <div class="col-lg">
            <form action="{{ route('pembina-jadwal.index') }}" method="GET">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Filter Jadwal Ekstrakurikuler</h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <select name="eskul_id" class="form-control @error('eskul_id') is-invalid @enderror"
                                        id="pilihEskul">
                                        <option value="" selected>Pilih Ekstrakurikuler</option>
                                        @foreach ($eskuls as $data)
                                            <option value="{{ $data->id }}"
                                                {{ request('eskul_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('eskul_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <input type="text" name="tanggal" class="form-control"
                                        value="{{ request('tanggal') }}" id="bulanDateId">
                                </div>
                            </div>
                            <div class="col-lg">
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="fa fa-search"></i>
                                    Cari Jadwal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('pembina-jadwal.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Tambahkan Data
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <h4 class="card-title">List Data Jadwal Esktrakurikuler</h4>
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%">No.</th>
                                <th>Ekskul</th>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwals as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->eskul->nama ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d F Y') }}</td>
                                    <td>{{ $data->lokasi ?? '-' }}</td>
                                    <td>{{ $data->deskripsi ?? '-' }}</td>
                                    <td class="d-flex">
                                        <form action="{{ route('pembina-jadwal.destroy', $data->id) }}" method="POST"
                                            class="d-flex">
                                            @csrf
                                            <a href="{{ route('pembina-jadwal.edit', $data->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="submit" class="btn btn-sm btn-danger mx-2" id="hapusData">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-script')
    <script>
        $(document).ready(function() {
            $('#pilihEskul').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#bulanDateId').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().startOf('year'), // Mulai dari awal tahun ini
                endDate: moment().endOf('year'),
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function(start, end) {
                $('#bulanDateId').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            @if (Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
            @endif

            @if (Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @endif
        });
    </script>
    <script>
        // Mendengarkan acara klik tombol hapus
        $(document).on('click', '#hapusData', function(event) {
            event.preventDefault(); // Mencegah perilaku default tombol

            // Ambil URL aksi penghapusan dari atribut 'action' formulir
            var deleteUrl = $(this).closest('form').attr('action');

            // Tampilkan SweetAlert saat tombol di klik
            Swal.fire({
                icon: 'question',
                title: 'Hapus Data Jadwal ?',
                text: 'Apakah anda yakin untuk menghapus data ini?',
                showCancelButton: true, // Tampilkan tombol batal
                confirmButtonText: 'Ya',
                confirmButtonColor: '#28a745', // Warna hijau untuk tombol konfirmasi
                cancelButtonText: 'Tidak',
                cancelButtonColor: '#dc3545' // Warna merah untuk tombol pembatalan
            }).then((result) => {
                // Lanjutkan jika pengguna mengkonfirmasi penghapusan
                if (result.isConfirmed) {
                    // Kirim permintaan AJAX DELETE ke URL penghapusan
                    $.ajax({
                        url: deleteUrl,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}" // Kirim token CSRF untuk keamanan
                        },
                        success: function(response) {
                            // Tampilkan pesan sukses jika penghapusan berhasil
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data Berhasil Dihapus.',
                                showConfirmButton: false,
                                timer: 1500 // Durasi pesan success (dalam milidetik)
                            });

                            // Refresh halaman setelah pesan sukses ditampilkan
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        },
                        error: function(xhr, status, error) {
                            // Tampilkan pesan error jika penghapusan gagal
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                showConfirmButton: false,
                                timer: 1500 // Durasi pesan error (dalam milidetik)
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
