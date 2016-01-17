<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function choiceOptions()
    {
        return $this->hasMany('Kneu\Survey\QuestionChoiceOption');
    }
}
