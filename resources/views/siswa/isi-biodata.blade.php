@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="/edit-biodata/siswa/store" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="/dashboard" class="btn btn-primary">
                            <i class="fa fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i>
                            Simpan Data
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>NIS</label>
                                    <input type="number" name="nis"
                                        class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}"
                                        placeholder="Masukan nis">
                                    @error('nis')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', Auth()->user()->name ?? '-') }}"
                                        placeholder="Masukan nama lengkap">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Pilih Jenis Kelamin</label>
                                    <select name="jk" class="form-control @error('jk') is-invalid @enderror"
                                        id="pilihJenisKelamin">
                                        <option value="" selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki" {{ old('jk') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="Perempuan" {{ old('jk') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Pilih Jurusan</label>
                                    <select name="jurusan_id" class="form-control @error('jurusan_id') is-invalid @enderror"
                                        id="pilihJurusan">
                                        <option value="" selected>Pilih Jurusan</option>
                                        @foreach ($jurusans as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('jurusan_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama_jurusan ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('jurusan_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Pilih Kelas</label>
                                    <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror"
                                        id="pilihKelas">
                                        <option value="" selected>Pilih Kelas</option>
                                    </select>
                                    @error('kelas_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('custom-script')
    <script>
        $(document).ready(function() {
            $('#pilihPengguna').select2({
                theme: 'bootstrap4',
            });
            $('#pilihJenisKelamin').select2({
                theme: 'bootstrap4',
            });
            $('#pilihKelas').select2({
                theme: 'bootstrap4',
            });
            $('#pilihJurusan').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#pilihJurusan').on('change', function() {
                let id_jurusan = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: "/jquery-kelas/dashboard",
                    data: {
                        id_jurusan: id_jurusan
                    },
                    cache: false,
                    success: function(data) {
                        $('#pilihKelas').html(data);
                    },
                    error: function(data) {
                        console.log('error: ', data);
                    }
                });
            });
        });
    </script>
@endpush
