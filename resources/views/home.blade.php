@extends('layouts.main')

@section('content')
    <home remote-ip="{{ request()->ip() }}"></home>
@endsection
