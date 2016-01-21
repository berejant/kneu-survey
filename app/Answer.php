<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 * @package Kneu\Survey
 * @property Questionnaire $questionnaire
 * @property Question $question
 * @property QuestionChoiceOption $questionChoiceOption
 */
class Answer extends Model
{

    public $timestamps = false;

    protected $fillable = ['questionnaire_id', 'question_id'];

    public function question()
    {
        return $this->belongsTo('Kneu\Survey\Question');
    }

    public function questionnaire()
    {
        return $this->belongsTo('Kneu\Survey\Questionnaire');
    }

    public function questionChoiceOption()
    {
        return $this->belongsTo('Kneu\Survey\QuestionChoiceOption');
    }

    public function saveValue($value)
    {
        $value = $value ? trim($value) : '';

        if(!$value) {
            $this->delete();
            return false;
        }

        switch($this->question->type) {
            case 'text':
                $this->text = $value;
                break;

            case 'choice':
                /** @var QuestionChoiceOption $questionChoiceOption */
                $questionChoiceOption = QuestionChoiceOption::findOrFail($value);
                $this->questionChoiceOption()->associate($questionChoiceOption);
                break;
        }

        $this->save();

        return true;
    }

}
