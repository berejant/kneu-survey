<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Class Teacher
 * @package Kneu\Survey
 * @property Collection $questionnaires
 * @property integer $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string photo
 */
class Teacher extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'first_name', 'middle_name', 'last_name',
        'position', 'link', 'photo', 'department_name'
    ];

    public $incrementing = false;

    public function questionnaires()
    {
        return $this->hasMany('Kneu\Survey\Questionnaire');
    }

    public function questionResults()
    {
        return $this->hasMany('Kneu\Survey\QuestionResult');
    }

    public function teacherResults()
    {
        return $this->hasMany('Kneu\Survey\TeacherResult');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name;
    }

    public function getInitials()
    {
        return Str::limit($this->first_name, 1, '.') . Str::limit($this->middle_name, 1, '.');
    }

}
