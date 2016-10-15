@extends('layouts.main')

@section('title')
    Результати анкетування за викладачами
@endsection

@section('subtitle')
    Результати анкетування за викладачами
@endsection

@section('content')

    <style>
        .links a {
            margin-right: 15px;
        }
    </style>

    <div class="text-right links">
        <a href="{{URL::route('admin.launchStatus')}}" class="btn btn-default">Запуск анкетування</a>
        <a href="https://kneu.edu.ua/journal/survey/stat/completedByGroups.php" class="btn btn-default">Статистика по групам</a>
    </div>

    <input type="text" class="form-control" id="filter" placeholder="Фільтрувати">

    <div class="list-group" id="list">
        @foreach ($teachers as $teacher)
        <a href="{{URL::route('admin.teacher', [$teacher])}}" class="list-group-item">
            <span class="badge">{{ $teacher->count }}</span>
            <span class="name">{{ $teacher->getName() }}</span>
        </a>
        @endforeach
    </div>

    <script>
        $('#filter').on('keyup change', function () {
            var value = $(this).val();
            value = $.trim(value).toLowerCase();

            if(!value) {
                $('#list a').show();
            } else {
                $('#list a').each(function () {
                    var show = $('.name', this).text().toLowerCase().indexOf(value) !== -1;
                    $(this)[show ? 'show' : 'hide']();
                });
            }
        }).triggerHandler('change');
    </script>
@stop