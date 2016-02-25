<?php


namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Result
 * @package Kneu\Survey
 */
class Result extends Model
{
    protected $fillable = ['teacher_id', 'question_id', 'question_choice_option_id', 'academic_year', 'semester'];

    public function question()
    {
        return $this->belongsTo('Kneu\Survey\Question');
    }

    public function teacher()
    {
        return $this->belongsTo('Kneu\Survey\Teacher');
    }

    public function questionChoiceOption()
    {
        return $this->belongsTo('Kneu\Survey\QuestionChoiceOption');
    }

    public function setPortion($value)
    {
        $this->attributes['portion'] = $value * 100;
    }

}