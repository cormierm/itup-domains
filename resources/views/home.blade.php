@extends('layouts.main')

@section('content')
    <home :alert="{{ json_encode($alert ?? null) }}" remote-ip="{{ request()->ip() }}"></home>
@endsection
