<?php
use \Illuminate\Support\Facades\Config;
?>
@extends('layouts.main')

@section('title', 'Анкетування студентів')

@section('content')
    <div class="jumbotron">
        <h3 class="col-xs-offset-3">Шановний студенте!</h3>
        <p class="text-justify col-xs-offset-3">
            Дякую за участь в опитуванні!<br />
            Ваша думка буде врахована.<br />
            Бажаю наснаги та успіхів у навчанні!<br />
        </p>
        <p class="text-justify col-xs-offset-7">
            Дякую за небайдужість,<br />
            декан факультету Востряков О.В.
        </p>

        <p class="text-justify">
            <span class="label label-warning">Увага!</span> <strong>Анонімність гарантується!</strong><br />
            <small>Жоден викладач або співробітник факультету не дізнається, ким саме було надіслано анкету.</small>
        </p>

        <div class="finish-footer">
            <div class="content">
                <a class="btn-exit" href="{{Config::get('app.exitUrl')}}" role="button" onclick="window.close();">
                    Завершити
                    <i class="glyphicon glyphicon-ok"></i>
                </a>
            </div>

            <form class="restart-form" method="post" action="{{URL::route('survey.restart')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn-restart" name="restart" id="restart" value="1" title="Для коригування відповідей або заповнення анкети заново">
                    Редагувати відповіді
                    <i class="glyphicon glyphicon-repeat"></i>
                </button>
            </form>

        </div>
    </div>
@stop