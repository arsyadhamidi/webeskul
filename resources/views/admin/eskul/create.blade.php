@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-eskul.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-eskul.index') }}" class="btn btn-primary">
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
                                    <label>Nama Ekstrakurikuler</label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama') }}" placeholder="Masukan Nama Status">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Gambar Ekstrakurikuler</label>
                                    <input type="file" name="gambar_eskul"
                                        class="form-control @error('gambar_eskul') is-invalid @enderror">
                                    @error('gambar_eskul')
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
