<?php
/**
 * @var \Kneu\Survey\Questionnaire $questionnaire
 * @var \Illuminate\Database\Eloquent\Collection $questions
 * @var \Illuminate\Database\Eloquent\Collection $answers (assoc by question_id)
 * @var \Kneu\Survey\Question $question
 */
?>
@extends('layouts.main')

@section('title', 'Анкетування студентів')

@section('content')

    <form method="post" id="quuestionnaire" class="quuestionnaire"
          action="{{URL::action('SurveyController@postQuuestionnaire', [$student,  $student->getSecret()])}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="questionnaire_id" value="{{$quuestionnaire->id}}">
        <fieldset>
            <legend class="teacher">
                <div class="photo">
                @if($teacher->photo)
                    <img src="{{$teacher->photo}}">
                @endif
                </div>

                <div class="info">

                    <div class="postion">
                    @if($teacher->position)
                        {{$teacher->position}}
                    @else
                        Викладач
                    @endif
                    </div>

                    <h3>{{$teacher->getName()}}</h3>

                </div>

                <div class="skip">
                    <button type="button" name="skip" value="1" class="btn btn-default" data-toggle="modal" data-target="#skipConfirm">
                        Пропустити викладача
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>

            </legend>

            @foreach($questions as $index => $question)
                <?php $answer = $answers->get($question->id) ?>
                @include('survey.question.' . $question->type)
            @endforeach

            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">
                        Зберегти анкету
                        <i class="glyphicon glyphicon-ok"></i>
                    </button>
                </div>
            </div>
        </fieldset>

        <div class="modal fade" role="dialog" id="skipConfirm" aria-labelledby="skipConfirmLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="skipConfirmLabel">Підтвердження</h4>
                    </div>
                    <div class="modal-body">
                        <p>Ви дійсно хочете пропустити заповнення анкети стосовно цього викладача?<br />
                            Жодні Ваші відповіді не будуть збережені.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Ні, продовжити</button>
                        <button type="submit" class="btn btn-primary" name="skip" value="1">Так, перейти до наступного викладача</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@stop