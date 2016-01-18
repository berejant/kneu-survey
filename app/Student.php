<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    public $timestamps = false;

    public $incrementing = false;

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    public function questionnaires()
    {
        return $this->hasMany('Kneu\Survey\Questionnaire');
    }

    public function checkIsCompleted($forceIsCompleted = true)
    {
        $this->is_completed = $forceIsCompleted;

        // если нам не передано is_completed = false -> то проверяем по анкетам-потомкам
        if($this->is_completed) {
            /** @var Questionnaire $questionnaire */
            foreach ($this->questionnaires as $questionnaire) {
                if (!$questionnaire->is_completed) {
                    $this->is_completed = false;
                    break;
                }
            }
        }

        $this->save();
        return $this->is_completed;
    }

}
