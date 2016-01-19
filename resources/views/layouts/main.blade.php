<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link href="/css/app.css" rel="stylesheet">
    <script src="/js/vendor.js"></script>
</head>
<body>
<div class="container animate">
    @yield('content')
</div>
</body>
</html>