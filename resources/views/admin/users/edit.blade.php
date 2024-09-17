@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-users.update', $users->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-users.index') }}" class="btn btn-primary">
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
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $users->name ?? '0') }}"
                                        placeholder="Masukan nama lengkap">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Username</label>
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        value="{{ old('username', $users->username ?? '0') }}" placeholder="Masukan Username" readonly>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Status Autentikasi</label>
                                    <select name="level_id" class="form-control @error('level_id') is-invalid @enderror"
                                        id="pilihStatusAutentikasi">
                                        <option value="" selected>Pilih Status</option>
                                        @foreach ($levels as $data)
                                            <option value="{{ $data->id_level }}"
                                                {{ $users->level_id == $data->id_level ? 'selected' : '' }}>
                                                {{ $data->namalevel ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('level_id')
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
                                        value="{{ old('telp', $users->telp ?? '0') }}" placeholder="Masukan nomor telepon">
                                    @error('telp')
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
            $('#pilihStatusAutentikasi').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
