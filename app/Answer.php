<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo('Kneu\Survey\Question');
    }

    public function questionnaire()
    {
        return $this->belongsTo('Kneu\Survey\Questionnaire');
    }

    public function questionChoiceOption()
    {
        return $this->belongsTo('Kneu\Survey\QuestionChoiceOption');
    }

}
