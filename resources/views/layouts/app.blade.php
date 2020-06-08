<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('/css/global.css')}}">
    <title>@yield('page-title')</title>
</head>
<body>
<div id="app">
    <?php $user = auth()->user();if ($user != null) $user->hasRole('admin');?>
    <header-component :user="{{json_encode($user)}}"></header-component>
    @yield('content')
    <footer-component></footer-component>
</div>
<script src="{{ asset('js/app.js')}}"></script>

</body>
</html>
