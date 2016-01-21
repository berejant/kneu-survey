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
    <div class="page-header">
        <div class="pull-left" style="padding: 8px 24px 0 0">
            <img src="/img/feu.jpg" />
        </div>

        <h1>Анкетування студентів ФЕтаУ<br /><small>анонімне опитування студентської думки</small><br /></h1>
    </div>

    <div class="clearfix"></div>
    @yield('content')
</div>
</body>
</html>