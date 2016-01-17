<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;

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

}
