@extends('admin.layout.master')

@section('content')
    <div class="row">
        @foreach ($eskuls as $data)
            <div class="col-lg-3">
                <div class="mb-3">
                    <a href="{{ route('daftar-eskul.create', $data->id) }}" style="text-decoration: none">
                        <div class="card">
                            <div class="card-body">
                                <h3>{{ $data->nama ?? '-' }}</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
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
