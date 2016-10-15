@extends('layouts.main')

@section('title')
    Запуск анкетування
@endsection

@section('subtitle')
@endsection

@section('content')

    <a href="{{URL::route('admin.launchStatus')}}" class="btn btn-default" onclick="document.referrer===this.href && history.back()">
        <i class="glyphicon glyphicon-arrow-left"></i>
        Назад
    </a>

    <div class="alert alert-danger" role="alert">
        Виникла помилка: {{$error}}
    </div>
@stop