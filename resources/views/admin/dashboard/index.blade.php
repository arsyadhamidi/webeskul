@extends('admin.layout.master')

@section('content')
    @if (Auth()->user()->level_id == '1')
        @include('admin.index')
    @elseif (Auth()->user()->level_id == '4')
        @include('siswa.index')
    @endif
@endsection
