<?php namespace Kneu\Survey;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * Class Student
 * @package Kneu\Survey
 * @property Collection $questionnaires
 * @property bool is_completed
 */
class Student extends Model
{
    public $timestamps = false;

    public $incrementing = false;

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    protected $secret;

    /**
     * @var \stdClass
     */
    protected $surveyStatistics;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionnaires()
    {
        return $this->hasMany('Kneu\Survey\Questionnaire');
    }

    /**
     * @return Collection
     */
    public function getTeachers()
    {
        $this->load('questionnaires.teacher');

        $collection = new Collection();

        foreach ($this->questionnaires as $questionnaire) {
            /** @var Questionnaire $questionnaire */
            $collection->add($questionnaire->teacher);
        }

        return $collection;
    }

    /**
     * @param bool $forceIsCompleted
     * @return bool
     */
    public function checkIsCompleted($forceIsCompleted = true)
    {
        $this->is_completed = $forceIsCompleted;

        // если нам не передано is_completed = false -> то проверяем по анкетам-потомкам
        if ($this->is_completed) {
            $this->load('questionnaires');

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

    /**
     * @return string
     */
    public function getSecret()
    {
        if (!$this->secret) {
            $salt = Config::get('student.secret_salt');
            $string = sprintf($salt, $this->id);
            $this->secret = md5($string);
        }

        return $this->secret;
    }

    /**
     * @return Questionnaire|null
     */
    public function getFirstNotCompletedQuestionnaire()
    {
        $questionnaire = $this->questionnaires()->where('is_completed', '=', false)->first();

        /**
         * Проверка целостности данных.
         * Если не найдена незаполненная анкета - то значит все анкеты заполнены.
         */
        if(!$questionnaire && !$this->is_completed ) {
            $this->checkIsCompleted();
        }

        return $questionnaire;
    }

    public function getSurveyStatistics()
    {
        if(!$this->surveyStatistics) {
            $this->surveyStatistics = $stats = new \stdClass;
            $stats->total = $this->questionnaires()->count();
            $stats->completed = $this->questionnaires()->where('is_completed', '=', true)->count();
        }

        return $this->surveyStatistics;
    }


}
