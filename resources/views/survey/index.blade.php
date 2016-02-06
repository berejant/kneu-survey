@extends('layouts.main')

@section('title', 'Анкетування студентів')

@section('content')
    <div class="jumbotron">
        <h3>Шановний студенте!</h3>
        <p class="text-justify">
            На факультеті економіки та управління запроваджено регулярний моніторинг якості освітнього процесу!<br />
            Прошу взяти участь в анкетуванні та оцінити якість занять у минулому семестрі!<br />
            Думка студентів, як основних споживачів освітніх послуг, має велике значення,<br />
            саме тому розраховую на вашу активну участь та об’єктивність!<br />
        </p>
        <p class="text-left col-xs-offset-6">
            З повагою,<br />
            декан&nbsp;факультету О.В.&nbsp;Востряков
        </p>

        <p class="text-left">
            <span class="label label-warning">Увага!</span> <strong>Анонімність&nbsp;гарантується!</strong><br />
            <small>Жоден викладач чи співробітник не дізнається, ким надіслано анкету.</small>
        </p>

        <p class="text-center" style="margin:50px 0 0 0;">
            <a class="btn btn-primary btn-lg" href="{{$questionnaireUrl}}" role="button">Розпочати анкетування</a>
        </p>
    </div>
@stop