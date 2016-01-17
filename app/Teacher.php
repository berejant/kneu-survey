<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function questionnaires()
    {
        return $this->hasMany('Kneu\Survey\Questionnaire');
    }

}
