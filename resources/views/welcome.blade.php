<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>

            html, body {

                color: white;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }


        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url(app()->getLocale() . '/users/users') }}">Home</a>
                    @else
                        <a href="{{ route('login', app()->getLocale()) }}">{{ __('Login') }}</a>

                        {{--@if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif--}}
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Online objednávkový systém
                </div>
                <div>
                    <h2>Bakalárska práca</h2>
                </div>

            </div>
        </div>

    </body>
</html>
https://github.com/riso159753/BP.git
