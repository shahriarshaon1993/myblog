<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>myblog - dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
        <meta name="description" content="This is an example dashboard created using build-in elements and components.">
        <meta name="msapplication-tap-highlight" content="no">

        <link href="{{ asset('main.css') }}" rel="stylesheet"></head>
    </head>
    <body>
        <div id="app">
            <mainapp></mainapp>
        </div>

        <script type="text/javascript" src="{{ asset('assets/scripts/main.js') }}"></script>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
