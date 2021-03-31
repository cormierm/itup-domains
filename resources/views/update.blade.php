@extends('layouts.main')

@section('content')
    <update hostname="{{ $hostname }}" remote-ip="{{ request()->ip() }}"></update>
@endsection
