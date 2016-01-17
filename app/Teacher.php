<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'first_name', 'middle_name', 'last_name', 'link', 'photo'];

    public $incrementing = false;

    public function questionnaires()
    {
        return $this->hasMany('Kneu\Survey\Questionnaire');
    }

}
