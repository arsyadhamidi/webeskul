<div class="row">
    <div class="col-lg">
        @php
            $pembinas = \App\Models\Pembina::where('users_id', Auth()->user()->id)->first();
        @endphp
        <div class="card">
            <div class="card-header">
                @if (empty($pembinas))
                    <a href="/isi-biodata/pembina" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Isi Biodata
                    </a>
                @else
                    <a href="/edit-biodata/pembina/{{ $pembinas->id }}" class="btn btn-primary">
                        <i class="fa fa-edit"></i>
                        Edit Biodata
                    </a>
                @endif
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="3">Biodata Pembina</th>
                    </tr>
                    <tr>
                        <td style="width: 20%">NIP</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $pembinas->nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Nama Lengkap</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $pembinas->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Jenis Kelamin</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $pembinas->jk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Telepon</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $pembinas->telp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Ekstrakurikuler</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $pembinas->eskul->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Username</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $pembinas->users->username ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Status</td>
                        <td style="width: 5%">:</td>
                        <td>Pembina</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Telepon</td>
                        <td style="width: 5%">:</td>
                        <td>{{ $pembinas->users->telp ?? '-' }}</td>
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
