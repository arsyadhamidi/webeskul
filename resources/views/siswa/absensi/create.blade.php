@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('siswa-absensi.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('siswa-absensi.index') }}" class="btn btn-primary">
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
                                    <label>Pilih Ekstrakurikuler</label>
                                    <select name="eskul_id" class="form-control @error('eskul_id') is-invalid @enderror"
                                        id="pilihEskul">
                                        <option value="" selected>Pilih Ekstrakurikuler</option>
                                        @foreach ($eskuls as $data)
                                            <option value="{{ $data->eskul->id }}">{{ $data->eskul->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('eskul_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label>Status Absensi</label>
                                    <div class="form-group" style="margin-left: 30px">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="Hadir"
                                                checked>
                                            <label class="form-check-label">
                                                Hadir
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="Sakit">
                                            <label class="form-check-label">
                                                Sakit
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="Izin">
                                            <label class="form-check-label">
                                                Izin
                                            </label>
                                        </div>
                                    </div>
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
@endpush
