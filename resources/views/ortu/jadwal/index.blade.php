@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body table-responsive">
                    <h4 class="card-title">List Data Jadwal Esktrakurikuler</h4>
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%">No.</th>
                                <th>Ekskul</th>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwals as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->eskul->nama ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d F Y') }}</td>
                                    <td>{{ $data->lokasi ?? '-' }}</td>
                                    <td>{{ $data->deskripsi ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
