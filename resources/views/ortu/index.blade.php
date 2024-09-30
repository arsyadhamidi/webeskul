<div class="row">
    <div class="col-lg">
        @php
            $ortus = \App\Models\OrangTua::where('users_id', Auth()->user()->id)->first();
        @endphp
        <div class="card">
            <div class="card-header">
                @if (empty($ortus))
                    <a href="/isi-biodata/ortu" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Isi Biodata
                    </a>
                @else
                    <a href="/edit-biodata/ortu/{{ $ortus->id }}" class="btn btn-primary">
                        <i class="fa fa-edit"></i>
                        Edit Biodata
                    </a>
                @endif
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="3">Biodata Orang Tua</th>
                    </tr>
                    <tr>
                        <td style="width: 20%">Siswa</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $ortus->siswa->nis ?? '-' }} - {{ $ortus->siswa->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Nama Lengkap</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $ortus->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Jenis Kelamin</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $ortus->jk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Telepon</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $ortus->telp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Alamat</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $ortus->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Username</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $ortus->users->username ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Status</td>
                        <td style="width: 5%">:</td>
                        <td>Orang Tua</td>
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
