@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('pembina-pendaftaran.update', $daftars->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('pembina-pendaftaran.index') }}" class="btn btn-primary">
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
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label>Pilih Siswa</label>
                                    <select name="siswa_id" class="form-control @error('siswa_id') is-invalid @enderror"
                                        id="pilihSiswa">
                                        <option value="" selected>Pilih Siswa</option>
                                        @foreach ($siswas as $data)
                                            <option value="{{ $data->id }}"
                                                {{ $daftars->siswa_id == $data->id ? 'selected' : '' }}>
                                                {{ $data->nis ?? '-' }} - {{ $data->nama ?? '-' }}</option>
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
                                    <label>NISN</label>
                                    <input type="text" name="nis"
                                        class="form-control @error('nis', $daftars->nis ?? '-') is-invalid @enderror" value="{{ old('nis', $daftars->nis ?? '-') }}"
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
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $daftars->nama ?? '-') }}" placeholder="Masukan nama lengkap">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tmp_lahir"
                                        class="form-control @error('tmp_lahir') is-invalid @enderror"
                                        value="{{ old('tmp_lahir', $daftars->tmp_lahir) }}" placeholder="Masukan tempat lahir">
                                    @error('tmp_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir"
                                        class="form-control @error('tgl_lahir') is-invalid @enderror"
                                        value="{{ old('tgl_lahir', $daftars->tgl_lahir) }}">
                                    @error('tgl_lahir')
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
                                        id="pilihJekel">
                                        <option value="" selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki" {{ $daftars->jk == 'Laki-Laki' ? 'selected' : '' }}>
                                            Laki-Laki</option>
                                        <option value="Perempuan" {{ $daftars->jk == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
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
                                        value="{{ old('telp', $daftars->telp ?? '0') }}"
                                        placeholder="Masukan nomor telepon">
                                    @error('telp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $daftars->email ?? '-') }}"
                                        placeholder="Masukan email address">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Pilih Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror"
                                        id="pilihStatus">
                                        <option value="" selected>Pilih Status</option>
                                        <option value="Diterima" {{ $daftars->status == 'Diterima' ? 'selected' : '' }}>
                                            Diterima</option>
                                        <option value="Proses" {{ $daftars->status == 'Proses' ? 'selected' : '' }}>Proses
                                        </option>
                                        <option value="Ditolak" {{ $daftars->status == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Alasan</label>
                                    <input type="text" name="alasan"
                                        class="form-control @error('alasan') is-invalid @enderror"
                                        value="{{ old('alasan', $daftars->alasan ?? '-') }}"
                                        placeholder="Masukan alasan">
                                    @error('alasan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <input type="text" name="alamat"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        value="{{ old('alamat', $daftars->alamat ?? '-') }}"
                                        placeholder="Masukan alamat">
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Berkas Pendaftaran</label>
                                    <input type="file" name="berkas_pendaftaran"
                                        class="form-control @error('berkas_pendaftaran') is-invalid @enderror"
                                        value="{{ old('berkas_pendaftaran') }}">
                                    @error('berkas_pendaftaran')
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
            $('#pilihEskul').select2({
                theme: 'bootstrap4',
            });
            $('#pilihSiswa').select2({
                theme: 'bootstrap4',
            });
            $('#pilihJekel').select2({
                theme: 'bootstrap4',
            });
            $('#pilihStatus').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
