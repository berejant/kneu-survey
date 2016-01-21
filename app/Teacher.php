<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Teacher
 * @package Kneu\Survey
 * @property Collection $questionnaires
 */
class Teacher extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'first_name', 'middle_name', 'last_name', 'position', 'link', 'photo'];

    public $incrementing = false;

    public function questionnaires()
    {
        return $this->hasMany('Kneu\Survey\Questionnaire');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name;
    }

}
