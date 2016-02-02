@extends('layouts.main')

@section('title', 'Анкетування студентів')

@section('content')
    <div class="jumbotron">
        <h3>Шановний студенте!</h3>
        <p class="text-justify">
            Візьміть участь в анкетуванні!<br />
            Пам'ятайте, тільки Ви, як споживач, маєте право оцінювати якість отриманих освітніх послуг!<br />
            Сподіваюсь на Вашу об’єктивність!
        </p>
        <p class="text-left col-xs-offset-6">
            Дякую за небайдужість,<br />
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