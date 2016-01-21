<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Question
 * @package Kneu\Survey
 * @property int $id
 * @property Collection $choiceOptions
 * @property Collection $answers
 */
class Question extends Model
{

    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function choiceOptions()
    {
        return $this->hasMany('Kneu\Survey\QuestionChoiceOption');
    }

    public function answers()
    {
        return $this->hasMany('Kneu\Survey\Answer');
    }
}
