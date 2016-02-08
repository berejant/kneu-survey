<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Questionnaire
 * @package Kneu\Survey
 * @property Collection $answers
 * @property Student $student
 * @property Teacher $teacher
 * @property integer id
 * @property bool is_completed
 */
class Questionnaire extends Model
{

    public $timestamps = false;

    protected $fillable = ['academic_year', 'semester', 'student_id', 'teacher_id', 'rating'];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    public function answers()
    {
        return $this->hasMany('Kneu\Survey\Answer');
    }

    public function student()
    {
        return $this->belongsTo('Kneu\Survey\Student');
    }

    public function teacher()
    {
        return $this->belongsTo('Kneu\Survey\Teacher');
    }
}
