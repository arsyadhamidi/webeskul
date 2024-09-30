@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('pembina-pendaftaran.index') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th colspan="3">Biodata</th>
                        </tr>
                        <tr>
                            <td style="width: 20%">Nomor Pendaftaran</td>
                            <td style="width: 5%">:</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $daftars->nomor_pendaftaran ?? '0' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Tanggal Pendaftaran</td>
                            <td style="width: 5%">:</td>
                            <td>
                                {{ \Carbon\Carbon::parse($daftars->tgl_pendaftaran)->format('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 20%">NISN</td>
                            <td style="width: 5%">:</td>
                            <td>{{ $daftars->nis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Nama Lengkap</td>
                            <td style="width: 5%">:</td>
                            <td>{{ $daftars->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">TTL</td>
                            <td style="width: 5%">:</td>
                            <td>{{ $daftars->tmp_lahir ?? '-' }},
                                {{ \Carbon\Carbon::parse($daftars->tgl_lahir)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Jenis Kelamin</td>
                            <td style="width: 5%">:</td>
                            <td>{{ $daftars->jk ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Ekskuk</td>
                            <td style="width: 5%">:</td>
                            <td>{{ $daftars->eskul->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Jurusan</td>
                            <td style="width: 5%">:</td>
                            <td>{{ $daftars->jurusan->nama_jurusan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Kelas</td>
                            <td style="width: 5%">:</td>
                            <td>{{ $daftars->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Telepon</td>
                            <td style="width: 5%">:</td>
                            <td>{{ $daftars->telp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Email Address</td>
                            <td style="width: 5%">:</td>
                            <td>{{ $daftars->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Status</td>
                            <td style="width: 5%">:</td>
                            <td>
                                @if ($daftars->status == 'Diterima')
                                    <span class="badge badge-success">{{ $daftars->status ?? '-' }}</span>
                                @elseif($daftars->status == 'Proses')
                                    <span class="badge badge-warning">{{ $daftars->status ?? '-' }}</span>
                                @elseif($daftars->status == 'Ditolak')
                                    <span class="badge badge-danger">{{ $daftars->status ?? '-' }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ $daftars->status ?? '-' }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Alasan</td>
                            <td style="width: 5%">:</td>
                            <td>{{ $daftars->alasan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Alamat</td>
                            <td style="width: 5%">:</td>
                            <td>{{ $daftars->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Berkas Pendaftaran</td>
                            <td style="width: 5%">:</td>
                            <td>
                                @if ($daftars->berkas_pendaftaran)
                                    <a href="{{ asset('storage/' . $daftars->berkas_pendaftaran) }}" class="btn btn-sm btn-primary"
                                        target="_blank">
                                        <i class="fa fa-download"></i>
                                        Download
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
