@extends('layouts.main')

@section('content')
    <h1>ItUp.ca</h1>
    <form method="post">
        <label for="domain">Domain:</label>
        <input type="text" id="domain" name="domain">
        <input type="submit">
    </form>
@endsection
