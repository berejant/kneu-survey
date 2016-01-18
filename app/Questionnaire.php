<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{

    public $timestamps = false;

    protected $fillable = ['academic_year', 'semester', 'student_id', 'teacher_id'];

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
