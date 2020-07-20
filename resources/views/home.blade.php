@extends('layouts.main')

@section('content')
    <h1>ItUp.ca</h1>

    @if(session()->has('success'))
        <div>
            <h2>{{session()->get('success')}}</h2>
        </div>
    @endif

    @if(session()->has('errors'))
        <div>
            <h2>{{session()->get('errors')}}</h2>
        </div>
    @endif

    <form method="post" action="{{route('register')}}">
        @csrf

        <label for="sub_domain">Sub Domain:</label>
        <input type="text" id="sub_domain" name="sub_domain" value="{{old('sub_domain')}}">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{old('email')}}">

        <input type="submit">
    </form>
@endsection
