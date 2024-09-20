<div class="row">
    <div class="col-lg">
        @php
            $siswas = \App\Models\Siswa::where('users_id', Auth()->user()->id)->first();
        @endphp
        <div class="card">
            <div class="card-header">
                @if (empty($siswas))
                    <a href="/isi-biodata/siswa" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Isi Biodata
                    </a>
                @else
                    <a href="/edit-biodata/siswa/{{ $siswas->id }}" class="btn btn-primary">
                        <i class="fa fa-edit"></i>
                        Edit Biodata
                    </a>
                @endif
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="3">Biodata Siswa</th>
                    </tr>
                    <tr>
                        <td style="width: 20%">NIS</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $siswas->nis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Nama Lengkap</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $siswas->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Jenis Kelamin</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $siswas->jk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Jurusan</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $siswas->jurusan->nama_jurusan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Kelas</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $siswas->kelas->nama_kelas ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Username</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $siswas->users->username ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Status</td>
                        <td style="width: 5%">:</td>
                        <td>Siswa</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Telepon</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $siswas->users->telp ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@push('custom-script')
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
