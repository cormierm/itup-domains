@extends('layouts.main')

@section('content')
    <edit hostname="{{ $hostname }}" remote-ip="{{ request()->ip() }}"></edit>
@endsection
