<?php namespace Kneu\Survey\Http\Controllers;

use Illuminate\Http\Request;
use Kneu\Survey\Answer;
use Kneu\Survey\Http\Requests;

use Kneu\Survey\Question;
use Kneu\Survey\Questionnaire;
use Kneu\Survey\Student;

class SurveyController extends Controller {

	public function __construct()
	{
		$this->middleware('Kneu\Survey\Http\Middleware\StudentAuthenticate');
	}

	/**
	 * @var Student $student
	 * @return Response
	 */
	public function getIndex(Student $student)
	{
		if($student->is_completed) {
			return redirect()->action('SurveyController@getFinish', [
				$student, $student->getSecret()
			]);
		}

		return view('survey.index', ['student' => $student]);
	}

	/**
	 * @var Student $student
	 * @return Response
	 */
	public function getNext(Student $student)
	{
		$quuestionnaire = $student->getFirstNotCompletedQuestionnaire();

		if(!$quuestionnaire) {
			return redirect()->action('SurveyController@getFinish', [
				$student, $student->getSecret()
			]);
		}

		$teacher = $quuestionnaire->teacher;
		$questions = Question::all();
		$answers = $quuestionnaire->answers->keyBy('question_id');

		return view(
			'survey.quuestionnaire',
			compact('quuestionnaire', 'teacher', 'student', 'questions', 'answers')
		);
	}

	public function postQuuestionnaire(Request $request, Student $student)
	{
		$questionnaire = $student->questionnaires()->find($request->input('questionnaire_id'));

		if(!$questionnaire) {
			abort(402);
		}

		if($request->input('skip', false)) {
			$questionnaire->is_completed = true;

		} else {

			$savedAnswersCount = 0;

			/** @var Question $question */
			foreach (Question::all() as $question) {
				$answerValue = $request->input('answers.' . $question->id);

				$status = Answer::firstOrNew([
					'questionnaire_id' => $questionnaire->id,
					'question_id' => $question->id,
				])->saveValue($answerValue);

				if ($status) {
					$savedAnswersCount++;
				}
			}

			if($savedAnswersCount) {
				$questionnaire->is_completed = true;
			}
		}

		$questionnaire->save();

		return $this->redirectNext($student);
	}


	public function getFinish(Student $student)
	{
		return view('survey.finish', ['student' => $student]);
	}

	public function postRestart(Request $request, Student $student)
	{
		if($request->input('restart')) {
			/** @var Questionnaire $questionnaire */
			foreach($student->questionnaires as $questionnaire)
			{
				$questionnaire->is_completed = false;
				$questionnaire->save();
			}
		}

		return $this->redirectNext($student);
	}

	protected function redirectNext ($student) {
		return redirect()->action('SurveyController@getNext', [
			$student, $student->getSecret()
		]);
	}
}
