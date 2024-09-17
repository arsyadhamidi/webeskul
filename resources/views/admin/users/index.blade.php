@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('data-users.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Tambahkan Data
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <h4 class="card-title">List Data Users Registrasi</h4>
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%">No.</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Telepon</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->name ?? '-' }}</td>
                                    <td>{{ $data->username ?? '-' }}</td>
                                    <td>{{ $data->level->namalevel ?? '-' }}</td>
                                    <td>{{ $data->telp ?? '-' }}</td>
                                    <td>
                                        @if ($data->foto_profile)
                                            <img src="{{ asset('images/profile.png') }}" class="img-fluid"
                                                style="width: 50px; height: 50px; object-fit: cover">
                                        @else
                                            <img src="{{ asset('images/profile.png') }}" class="img-fluid"
                                                style="width: 50px; height: 50px; object-fit: cover">
                                        @endif
                                    </td>
                                    <td class="d-flex">
                                        <form action="{{ route('data-users.destroy', $data->id) }}" method="POST"
                                            class="d-flex">
                                            @csrf
                                            <a href="{{ route('data-users.edit', $data->id) }}" class="btn btn-sm btn-info">
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
                title: 'Hapus Data Users ?',
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
