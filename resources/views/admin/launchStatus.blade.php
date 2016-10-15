@extends('layouts.main')

@section('title')
    Активація анкетування
@endsection

@section('subtitle')
    Запуск анкетування
@endsection

@section('content')
    <a href="{{URL::route('admin.list')}}" class="btn btn-default" onclick="document.referrer===this.href && history.back()">
        <i class="glyphicon glyphicon-arrow-left"></i>
        Назад
    </a>

    <form class="form-horizontal" action="{{URL::route('admin.launchChangeStatus')}}" method="post"
        onsubmit="$(':submit', this).prop('disabled').text('Очікуйте')"
    >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label class="col-sm-2 text-right">Статус:</label>
            <div class="col-sm-10">
                @if($status)
                    <span class="label label-success">Запущено</span>
                @else
                    <span class="label label-danger">Вимкнено</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="semester" class="col-sm-2 control-label">За період</label>
            <div class="col-sm-10">
                <select name="semester" id="semester" class="form-control">
                    <option value="" disabled></option>
                    @foreach($semesters as $semesterKey => $semester)
                        <option value="{{$semesterKey}}" @if($semesterSelected==$semesterKey)selected @endif>{{$semester}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                @if($status)
                    <button type="submit" name="status" value="0" class="btn btn-danger">Вимкнути</button>
                @else
                    <button type="submit" name="status" value="1" class="btn btn-success">Увімкнути</button>
                @endif
            </div>
        </div>

    </form>
@stop