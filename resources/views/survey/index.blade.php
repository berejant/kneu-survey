@extends('layouts.main')

@section('title', 'Анкетування студентів')

@section('content')
    <div class="jumbotron">
        <h3>Шановний студенте!</h3>
        <p class="text-justify">
            Прошу Вас взяти участь у оцінюванні якості проведення занять.<br />
            Ваша участь необхідна для підвищення якості надання освітніх послуг.<br />
            Результати анкетування дозволять здійснити моніторинг роботи викладачів.<br />
            Сподіваюсь на Вашу об’єктивність та зваженість Ваших відповідей.<br />
        </p>
        <p class="text-left col-xs-offset-6">
            Дякую за небайдужість,<br />
            декан&nbsp;факультету Востряков&nbsp;О.В.
        </p>

        <p class="text-left">
            <span class="label label-warning">Увага!</span> <strong>Анонімність&nbsp;гарантується!</strong><br />
            <small>Жоден викладач або співробітник факультету не дізнається, ким саме було надіслано анкету.</small>
        </p>

        <p class="text-center" style="margin:50px 0 0 0;">
            <a class="btn btn-primary btn-lg" href="{{$questionnaireUrl}}" role="button">Розпочати анкетування</a>
        </p>
    </div>
@stop