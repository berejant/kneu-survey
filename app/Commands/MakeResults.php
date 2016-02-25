<?php namespace Kneu\Survey\Commands;

use Kneu\Survey\Answer;
use Kneu\Survey\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Kneu\Survey\Question;
use Kneu\Survey\Questionnaire;
use Kneu\Survey\Teacher;
use Kneu\Survey\Result;

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

		$count = count($questionnaires);

		if(!$count) { // если по данному преподу опрос не проводился (нет анкет) - то нет смысла подвить итоги
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

		foreach($questionnaires as $questionnaire) {
			foreach($questionnaire->answers as $answer) {
				$question = $answer->question;
				$choiceOption = $answer->questionChoiceOption;

				if( $choiceOption ) {
					$results[ $question->id ] [ $choiceOption->id ] ++;
				}
			}
		}

		foreach($questions as $question ) {
			$questionResults = $results[ $question->id ];

			foreach($question->choiceOptions as $choiceOption ) {
				$result =  Result::firstOrNew([
					'academic_year' => $this->academicYear,
					'semester' => $this->academicSemester,
					'teacher_id' => $this->teacher->id,
					'question_id' => $question->id,
					'question_choice_option_id' => $choiceOption->id,
				]);

				$answersCount =  $questionResults[ $choiceOption->id ] ;

				$result->setPortion( $answersCount / $count );
				$result->save();
			}

			$notAnsweredValue = $count - array_sum($questionResults);

			$result =  Result::firstOrNew([
				'academic_year' => $this->academicYear,
				'semester' => $this->academicSemester,
				'teacher_id' => $this->teacher->id,
				'question_id' => $question->id,
				'question_choice_option_id' => null,
			]);
			$result->setPortion( $notAnsweredValue / $count );
			$result->save();

		}

	}

}
