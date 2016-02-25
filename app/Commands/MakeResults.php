<?php namespace Kneu\Survey\Commands;

use Kneu\Survey\Answer;
use Kneu\Survey\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Kneu\Survey\Question;
use Kneu\Survey\Questionnaire;
use Kneu\Survey\QuestionResult;
use Kneu\Survey\Teacher;
use Kneu\Survey\TeacherResult;

class MakeResults extends Command implements SelfHandling {

	/**
	 * @var integer
	 */
	protected $academicYear;

	/**
	 * @var integer
	 */
	protected $academicSemester;

	/**
	 * @var Teacher
	 */
	protected $teacher;

	/**
	 * Create a new command instance.
	 *
	 * @param integer $academicYear
	 * @param integer $academicSemester
	 * @param Teacher $teacher
	 * @return void
	 */
	public function __construct($academicYear, $academicSemester, Teacher $teacher)
	{
		$this->academicYear = $academicYear;
		$this->academicSemester = $academicSemester;

		$this->teacher = $teacher;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$questionnaires = $this->teacher->questionnaires()
			->whereIsCompleted(true)
			->whereAcademicYear($this->academicYear)->whereSemester($this->academicSemester)
			->get();

		if(!count($questionnaires)) { // если по данному преподу опрос не проводился (нет анкет) - то нет смысла подвить итоги
			return;
		}

		$results = [];
		/**
		 * @var Questionnaire $questionnaire
		 * @var Question $question
		 * @var Answer $answer
		 */
		$questions = Question::whereType('choice')->get();
		foreach ($questions as $question) {
			$results[$question->id] = [];

			foreach ($question->choiceOptions as $choiceOption) {
				$results[$question->id][$choiceOption->id] = 0;
			}
		}

		/** @var TeacherResult $resultTotal Количество заполненных анкет */
		$resultTotal = TeacherResult::firstOrNew([
			'academic_year' => $this->academicYear,   'semester' => $this->academicSemester,
			'teacher_id' => $this->teacher->id,       'type' => 'total',
		]);


		/** @var TeacherResult $resultSkipped Количество заполненных анкет */
		$resultFilled = TeacherResult::firstOrNew([
			'academic_year' => $this->academicYear,   'semester' => $this->academicSemester,
			'teacher_id' => $this->teacher->id,       'type' => 'fill',
		]);

		/** @var TeacherResult $resultSkipped Количество пропущенных анкет */
		$resultSkipped = TeacherResult::firstOrNew([
			'academic_year' => $this->academicYear,   'semester' => $this->academicSemester,
			'teacher_id' => $this->teacher->id,       'type' => 'skip',
		]);

		$resultTotal->count = count($questionnaires);
		$resultTotal->calculateAndSavePortion( $resultTotal->count );

		$resultFilled->count = 0;
		$resultSkipped->count = 0;
		foreach($questionnaires as $questionnaire) {
			foreach($questionnaire->answers as $answer) {
				$question = $answer->question;
				$choiceOption = $answer->questionChoiceOption;

				if($choiceOption) {
					$results[ $question->id ] [ $choiceOption->id ] ++;
				}
			}

			if(count($questionnaire->answers)) {
				$resultFilled->count++;
			} else {
				$resultSkipped->count++;
			}
		}
		unset($questionnaires, $question, $choiceOption);

		/** Количество непустых (заполненных) анкет */
		$resultFilled->calculateAndSavePortion( $resultTotal->count );
		$resultSkipped->calculateAndSavePortion( $resultTotal->count );

		if(!$resultFilled->count) { // если нет ни одной заполненой анкеты - детализацию по анкетам не вычисляем
			return;
		}

		foreach($questions as $question ) {
			/** @var array $questionResults массив (хеш) с набором кол-во выборов на вариантов ответа на вопрос */
			$questionResults = $results[ $question->id ];

			foreach($question->choiceOptions as $choiceOption ) {
				$result = QuestionResult::firstOrNew([
					'academic_year' => $this->academicYear,
					'semester' => $this->academicSemester,
					'teacher_id' => $this->teacher->id,
					'question_id' => $question->id,
					'question_choice_option_id' => $choiceOption->id,
				]);

				$result->count = $questionResults[ $choiceOption->id ];
				$result->calculateAndSavePortion( $resultFilled->count );
			}

			// От количетсва заполненных анкет отнимает кол-во ответов, получаем кол-во пропусков вопроса
			$result = QuestionResult::firstOrNew([
				'academic_year' => $this->academicYear,
				'semester' => $this->academicSemester,
				'teacher_id' => $this->teacher->id,
				'question_id' => $question->id,
				'question_choice_option_id' => null,
			]);
			$result->count = $resultFilled->count - array_sum($questionResults);
			$result->calculateAndSavePortion( $resultFilled->count );
		}

	}

}
