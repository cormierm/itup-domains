<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Vuetify Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            height: 100vh;
            margin: 0;
            font-family: Roboto, sans-serif;
        }
    </style>

</head>
<body>
    <div id="app">
        <v-app>
            <v-main>
                <app-nav-bar :fixed="true"></app-nav-bar>
                <app-nav-bar></app-nav-bar>
                @if(session()->has('alert'))
                    <v-alert type="{{ session()->get('alert')['type'] }}">
                        {{ session()->get('alert')['text'] }}
                    </v-alert>
                @endif
                @yield('content')
            </v-main>
        </v-app>
    </div>

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
