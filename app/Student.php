<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    public $timestamps = false;

    public $incrementing = false;

    public function questionnaires()
    {
        return $this->hasMany('Kneu\Survey\Questionnaire');
    }

}
