@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-dokumentasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-dokumentasi.index') }}" class="btn btn-primary">
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
                                    <label>Ekstrakurikuler</label>
                                    <select name="eskul_id" class="form-control @error('eskul_id') is-invalid @enderror"
                                        id="pilihEskul">
                                        <option value="" selected>Pilih Ekstrakurikuler</option>
                                        @foreach ($eskuls as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('eskul_id') == $data->id ? 'selected' : '' }}>
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
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label>Pembina</label>
                                    <select name="pembina_id" class="form-control @error('pembina_id') is-invalid @enderror"
                                        id="pilihPembina">
                                        <option value="" selected>Pilih Pembina</option>
                                    </select>
                                    @error('pembina_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Kegiatan</label>
                                    <input type="text" name="kegiatan"
                                        class="form-control @error('kegiatan') is-invalid @enderror"
                                        value="{{ old('kegiatan') }}" placeholder="Masukan Nama Kelas">
                                    @error('kegiatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Galeri</label>
                                    <input type="file" name="galeri"
                                        class="form-control @error('galeri') is-invalid @enderror"
                                        value="{{ old('galeri') }}">
                                    @error('galeri')
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
            $('#pilihPembina').select2({
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

            $('#pilihEskul').on('change', function() {
                let id_eskul = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: "/jquery-eskul",
                    data: {
                        id_eskul: id_eskul
                    },
                    cache: false,
                    success: function(data) {
                        $('#pilihPembina').html(data);
                    },
                    error: function(data) {
                        console.log('error: ', data);
                    }
                });
            });
        });
    </script>
@endpush
