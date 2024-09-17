@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-siswa.update', $siswas->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-siswa.index') }}" class="btn btn-primary">
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
                                                {{ $siswas->users_id == $data->id ? 'selected' : '' }}>
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
                                    <label>NIS</label>
                                    <input type="number" name="nis"
                                        class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $siswas->nis ?? '-') }}"
                                        placeholder="Masukan nis" readonly>
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
                                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $siswas->nama ?? '-') }}"
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
                                        <option value="Laki-Laki" {{ $siswas->jk == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="Perempuan" {{ $siswas->jk == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jk')
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
        });
    </script>
@endpush
