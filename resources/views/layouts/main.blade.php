<!--
          © 2016 Developed By Anton Berezhnyi
-->
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
    <header>
        <div class="faculty-icon"></div>

        <h1>Анкетування студентів ФЕтаУ<small>@yield('subtitle', 'анонімне опитування студентської думки')</small></h1>

        <div class="clearfix"></div>
    </header>

    <div class="clearfix"></div>
    @yield('content')

    <footer>
        © 2016 Факультет економiки та управлiння КНЕУ
        <div id="developer">Розробка: Антон Бережний</div>
    </footer>
</div>
</body>
</html>