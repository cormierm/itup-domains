@extends('layouts.main')

@section('content')
    <home :alert="{{ json_encode($alert ?? '') }}"></home>
@endsection
