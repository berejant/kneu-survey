<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionChoiceOption
 * @package Kneu\Survey
 * @property Question $question
 * @property Collection $answers
 */
class QuestionChoiceOption extends Model
{

    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo('Kneu\Survey\Question');
    }

    public function answers()
    {
        return $this->hasMany('Kneu\Survey\Answer');
    }

    public function questionResults()
    {
        return $this->hasMany('Kneu\Survey\QuestionResult');
    }

}
