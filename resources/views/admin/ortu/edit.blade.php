@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-ortu.update', $ortus->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-ortu.index') }}" class="btn btn-primary">
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
                                    <label>Pilih Pengguna</label>
                                    <select name="users_id" class="form-control @error('users_id') is-invalid @enderror"
                                        id="pilihPengguna">
                                        <option value="" selected>Pilih Pengguna</option>
                                        @foreach ($users as $data)
                                            <option value="{{ $data->id }}"
                                                {{ $ortus->users_id == $data->id ? 'selected' : '' }}>
                                                {{ $data->name ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('users_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Pilih Siswa</label>
                                    <select name="siswa_id" class="form-control @error('siswa_id') is-invalid @enderror"
                                        id="pilihSiswa">
                                        <option value="" selected>Pilih Siswa</option>
                                        @foreach ($siswas as $data)
                                            <option value="{{ $data->id }}"
                                                {{ $ortus->siswa_id == $data->id ? 'selected' : '' }}>{{ $data->nis ?? '-' }}
                                                - {{ $data->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('siswa_id')
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
                                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $ortus->nama ?? '-') }}"
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
                                        <option value="Laki-Laki" {{ $ortus->jk == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki
                                        </option>
                                        <option value="Perempuan" {{ $ortus->jk == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                        </option>
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
                                    <label>Nomor Telepon</label>
                                    <input type="number" name="telp"
                                        class="form-control @error('telp') is-invalid @enderror"
                                        value="{{ old('telp', $ortus->telp ?? '0') }}" placeholder="Masukan nomor telepon">
                                    @error('telp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="10" cols="10"
                                        placeholder="Masukan alamat domisili">{{ old('alamat', $ortus->alamat ?? '-') }}</textarea>
                                    @error('alamat')
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
            $('#pilihSiswa').select2({
                theme: 'bootstrap4',
            });
            $('#pilihJenisKelamin').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
