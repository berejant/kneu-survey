<?php
/**
 * @var \Kneu\Survey\Questionnaire $questionnaire
 * @var \Illuminate\Database\Eloquent\Collection $questions
 * @var \Illuminate\Database\Eloquent\Collection $answers (assoc by question_id)
 * @var \Kneu\Survey\Question $question
 * @var \Kneu\Survey\Answer $answer
 * @var \Kneu\Survey\QuestionChoiceOption $choiceOption
 */

$question->choiceOptions()
?>
<div class="form-group">
    <label for="answers_{{$question->id}}" class="control-label">{{ $index + 1 }}. {{$question->text}}</label>

    @foreach($question->choiceOptions as $choiceOption)
    <div class="radio">
        <label>
            <input type="radio" name="answers[{{$question->id}}]" id="answers_{{$choiceOption->id}}]" value="{{$choiceOption->id}}"
                   @if($answer && $choiceOption->id === $answer->questionChoiceOption->id) checked="checked"@endif>
            {{$choiceOption->text}}
        </label>
    </div>
    @endforeach
</div>