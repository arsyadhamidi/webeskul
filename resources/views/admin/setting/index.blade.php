@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4 text-center">
                        @if ($users->foto_profile)
                            <img src="{{ asset('storage/' . $users->foto_profile) }}" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover">
                        @else
                            <img src="{{ asset('images/profile.png') }}" class="img-fluid rounded-circle" width="150">
                        @endif
                    </div>
                    <div class="mb-4 text-center">
                        <h5>{{ $users->name ?? '-' }}</h5>
                        <p><i>{{ $users->level->namalevel ?? '-' }}</i></p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <p><b>Nama Lengkap</b><br>
                            <i>{{ $users->name ?? '-' }}</i>
                        </p>
                    </div>
                    <div class="mb-3">
                        <p><b>Username</b><br>
                            <i>{{ $users->username ?? '-' }}</i>
                        </p>
                    </div>
                    <div class="mb-3">
                        <p><b>Status</b><br>
                            <i>{{ $users->level->namalevel ?? '-' }}</i>
                        </p>
                    </div>
                    <div class="mb-3">
                        <p><b>Telepon</b><br>
                            <i>{{ $users->telp ?? '-' }}</i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg">
            <div class="mb-3">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile" type="button" role="tab"
                                    aria-controls="pills-profile" aria-selected="false">Ubah Username</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">Ubah Password</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-disabled-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-disabled" type="button" role="tab"
                                    aria-controls="pills-disabled" aria-selected="false">Ubah Gambar</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab" tabindex="0">
                                <form action="{{ route('setting.updateprofile') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg">
                                            <div class="mb-3">
                                                <label>Nama Lengkap</label>
                                                <input type="text" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="Masukan nama lengkap"
                                                    value="{{ old('name', $users->name ?? '-') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label>Nomor Telepon</label>
                                                <input type="number" name="telp"
                                                    class="form-control @error('telp') is-invalid @enderror"
                                                    placeholder="Masukan nama lengkap"
                                                    value="{{ old('telp', $users->telp ?? '-') }}">
                                                @error('telp')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bx bx-save"></i>
                                                    Simpan Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab" tabindex="0">
                                <form action="{{ route('setting.updateusername') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg">
                                            <div class="mb-3">
                                                <label>Username Lama</label>
                                                <input type="text" name="usernamelama"
                                                    class="form-control @error('usernamelama') is-invalid @enderror"
                                                    placeholder="Masukan username"
                                                    value="{{ old('usernamelama', $users->username ?? '-') }}" readonly>
                                                @error('usernamelama')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label>Username Baru</label>
                                                <input type="text" name="username"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    placeholder="Masukan username" value="{{ old('username') }}">
                                                @error('username')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bx bx-save"></i>
                                                    Simpan Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab" tabindex="0">
                                <form action="{{ route('setting.updatepassword') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg">
                                            <div class="mb-3 form-password-toggle">
                                                <label class="form-label" for="password">Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password"
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                        aria-describedby="password" />
                                                    <span class="input-group-text cursor-pointer"><i
                                                            class="bx bx-hide"></i></span>
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3 form-password-toggle">
                                                <label class="form-label" for="password">Konfirmasi Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="password"
                                                        class="form-control @error('konfirmasipassword') is-invalid @enderror"
                                                        name="konfirmasipassword"
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                        aria-describedby="password" />
                                                    <span class="input-group-text cursor-pointer"><i
                                                            class="bx bx-hide"></i></span>
                                                    @error('konfirmasipassword')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bx bx-save"></i>
                                                    Simpan Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-disabled" role="tabpanel"
                                aria-labelledby="pills-disabled-tab" tabindex="0">
                                <form action="{{ route('setting.updategambar') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg">
                                            <div class="mb-3">
                                                <label>Upload Gambar</label>
                                                <input type="file" name="foto_profile"
                                                    class="form-control @error('foto_profile') is-invalid @enderror">
                                                @error('foto_profile')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bx bx-save"></i>
                                                    Simpan Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($users->foto_profile)
                <div class="mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('setting.hapusgambar') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                Apakah Anda yakin ingin menghapus foto profil Anda? Tindakan ini tidak dapat dibatalkan dan
                                foto
                                profil akan dihapus secara permanen.
                                <br>
                                <br>
                                <button type="submit" class="btn btn-danger" id="hapusData">
                                    <i class='bx bx-trash'></i>
                                    Hapus Gambar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
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
                title: 'Hapus Foto Profile?',
                text: 'Apakah anda yakin untuk menghapus foto profile?',
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
                                title: 'Success',
                                text: 'Data successfully deleted.',
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
