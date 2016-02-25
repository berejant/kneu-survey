<?php


namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionnaireResult
 * @package Kneu\Survey
 */
class TeacherResult extends Model
{
    protected $fillable = ['type', 'teacher_id', 'academic_year', 'semester'];

    public function teacher()
    {
        return $this->belongsTo('Kneu\Survey\Teacher');
    }

    public function setPortion($value)
    {
        $this->attributes['portion'] = $value * 100;
    }

    /**
     * @param integer $total
     */
    public function calculateAndSavePortion ($total)
    {
        $this->setPortion( $this->count / $total );
        $this->save();
    }

    public function getTypeText ()
    {
        switch($this->type) {
            case 'total': return 'Всього анкет, у тому числі:';
            case 'skip': return 'Пропустили анкетування';
            case 'fill': return 'Заповнено анкет';
        }
    }

}