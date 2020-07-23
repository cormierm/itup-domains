@extends('layouts.main')

@section('content')
    <home :alert="{{ json_encode($alert ?? null) }}"></home>
@endsection
