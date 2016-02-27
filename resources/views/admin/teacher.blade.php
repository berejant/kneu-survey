<?php
/**
 * @var \Kneu\Survey\Teacher $teacher
 * @var stdClass $semester
 * @var \Kneu\Survey\Question $question
 * @var \Kneu\Survey\QuestionChoiceOption $choiceOption
 * @var \Kneu\Survey\Result $result
 * @var \Kneu\Survey\Answer $answer
 */

use Illuminate\Support\Str;

/**
 * Определяет, отображать ли строку с результатами. Отображать - если есть ненулыевые результаты за семестр
 * @param array $resultsBySemesters
 * @return bool
 */
function isShowResultRow(array $resultsBySemesters)
{
    /** @var \Kneu\Survey\QuestionResult $result */
    foreach($resultsBySemesters as $result) {
        if($result->count) {
            return true;
        }
    }

    return false;
}

?>
@extends('layouts.main')

@section('title')
    Результати анкетування за викладачем {{$teacher->last_name}} {{$teacher->getInitials()}}
@endsection

@section('subtitle')
    Результати анкетування за викладачем {{$teacher->last_name}} {{$teacher->getInitials()}}
@endsection

@section('content')

<legend class="teacher">
    <div class="photo">
        @if($teacher->photo)
            <img src="{{$teacher->photo}}">
        @endif
    </div>

    <div class="info">

        <div class="position">Кафедра {{ Str::lower($teacher->department_name) }}, {{$teacher->position ?: 'Викладач'}} </div>

        <h3>{{$teacher->getName()}}</h3>

        <div class="annotation">
            <span>Курс: {{$teacher->courses}};</span>
            <span>Дисципліна: {{$teacher->disciplines}}</span>
        </div>

    </div>
</legend>

<nav class="nav-teacher-report">
    <div>
        <a href="{{URL::route('admin.list')}}" class="btn btn-default" onclick="document.referrer===this.href?history.back():null;">
            <i class="glyphicon glyphicon-arrow-left"></i>
            Назад до списку
        </a>
    </div>

    <div class="text-right">
        Доля обраних відповідей,<br />
        у % від загальної кількості відповідей на запитання
    </div>
</nav>


<table class="teacher-report">
    <thead>
        <tr>
            <th class="text-right">Семестр:</th>
            @foreach($semesters as $semester)
                <th colspan="2" class="text-center">{{ $semester->academic_year }}-{{ $semester->academic_year + 1 }} / {{ $semester->semester }}</th>
            @endforeach
        </tr>

        <tr>
            <th>Питання</th>

            @foreach($semesters as $semester)
                <th>К-ть, шт.</th>
                <th>y %</th>
            @endforeach
        </tr>
    </thead>

    <?php $questionColspan = count($semesters) * 2 + 1; ?>

    <tbody>
        @foreach($teacherResults as $results)
            <?php $result = reset($results); ?>
            <tr class="result_{{ $result->type }}">
                <td class="result_label">{{ $result->getTypeText() }}</td>

                @foreach($semesters as $semesterKey => $semester)
                    <?php $result = $results[$semesterKey]; ?>
                    <td>{{$result->count}}</td>
                    <td>{{ number_format($result->portion, 0) }}</td>
                @endforeach
            </tr>
        @endforeach

        @foreach($questions as $question)
            <?php extract($question); ?>
            <tr class="active">
               <th colspan="{{ $questionColspan }}">{{$question->text}}</th>
            </tr>

            @foreach($question->choiceOptions as $choiceOption)
                <tr @if(!isShowResultRow($results[$choiceOption->id])) class="hidden-print" @endif>
                    <td>{{$choiceOption->text}}</td>

                    @foreach($semesters as $semesterKey=>$semester)
                        <?php $result = $results[$choiceOption->id][$semesterKey]; ?>
                        <td @if($result->portion > 50) class="success" @endif>{{$result->count}}</td>
                        <td @if($result->portion > 50) class="success" @endif>
                            {{ number_format($result->portion, 0) }}

                            @if($result->portion >= 90)
                                <i class="glyphicon glyphicon-ok"></i>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach

            <tr @if(!isShowResultRow($results['null'])) class="hidden-print" @endif>
                <td>Не надали відповідь</td>

                @foreach($semesters as $semesterKey=>$semester)
                    <?php $result = $results['null'][$semesterKey]; ?>
                    <td>{{$result->count}}</td>
                    <td>{{ number_format($result->portion, 0) }}</td>
                @endforeach
            </tr>

        @endforeach


        @foreach($textQuestions as $question)
            <?php $answers = $textAnswers[ $question->id ]; ?>
            <tr class="active">
                <th colspan="{{ $questionColspan }}">{{$question->text}}</th>
            </tr>

            <tr>
                <td colspan="{{ $questionColspan }}">
                    <ol>
                    @foreach($answers as $answer)
                        <li>{{$answer->text}}</li>
                    @endforeach
                    </ol>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
