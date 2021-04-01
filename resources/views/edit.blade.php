@extends('layouts.main')

@section('content')
    <edit incoming-hostname="{{ $hostname }}" remote-ip="{{ request()->ip() }}"></edit>
@endsection
