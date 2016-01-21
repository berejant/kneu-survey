<?php
/**
 * @var \Kneu\Survey\Questionnaire $questionnaire
 * @var \Illuminate\Database\Eloquent\Collection $questions
 * @var \Illuminate\Database\Eloquent\Collection $answers (assoc by question_id)
 * @var \Kneu\Survey\Question $question
 * @var \Kneu\Survey\Answer $answer
 */
?>
<div class="form-group">
    <label for="answers_{{$question->id}}" class="control-label">{{ $index + 1 }}. {{$question->text}}</label>
    <textarea class="form-control" rows="3" id="answers_{{$question->id}}" name="answers[{{$question->id}}]" placeholder="Впишіть Вашу відповідь...">{{$answer ? $answer->text : ''}}</textarea>
</div>