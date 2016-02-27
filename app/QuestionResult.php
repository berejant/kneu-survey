<?php


namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionResult
 * @package Kneu\Survey
 * @property int $id
 * @property integer $count
 * @property float $portion
 */
class QuestionResult extends Model
{
    protected $fillable = ['teacher_id', 'question_id', 'question_choice_option_id', 'academic_year', 'semester'];

    public function question()
    {
        return $this->belongsTo('Kneu\Survey\Question');
    }

    public function teacher()
    {
        return $this->belongsTo('Kneu\Survey\Teacher');
    }

    public function questionChoiceOption()
    {
        return $this->belongsTo('Kneu\Survey\QuestionChoiceOption');
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

}