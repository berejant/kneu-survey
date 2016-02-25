@extends('layouts.main')

@section('title')
    Результати анкетування за викладачами
@endsection

@section('subtitle')
    Результати анкетування за викладачами
@endsection

@section('content')

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
        })
    </script>
@stop