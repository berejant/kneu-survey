<?php namespace Kneu\Survey\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Kneu\Survey\Answer;
use Kneu\Survey\Http\Requests;

use Kneu\Survey\Question;
use Kneu\Survey\Questionnaire;
use Kneu\Survey\Student;
use Kneu\Survey\Teacher;

class SurveyController extends Controller {

	/**
	 * @var Student|null
	 */
	protected $student;

	/**
	 * SurveyController constructor.
	 * @param Request $request
     */
	public function __construct(Request $request)
	{
		$studentId = $request->session()->get('studentId');
		$this->student = $studentId ? Student::find($studentId) : null;

		list($controller, $actionName) = explode('@', $request->route()->getActionName());
		if(!$this->student && $actionName != 'auth') {
			abort(401);
		}
	}


	/**
	 * @var Student $student
	 * @return Response
	 */
	public function auth(Request $request, Student $student, $secret)
	{
		if( $student->getSecret() === $secret) {
			$request->session()->put('studentId', $student->id);
		} else {
			return abort(401);
		}

		return redirect()->route('survey.start');
	}

	/**
	 * @return Response
	 */
	public function start()
	{
		if($this->student->is_completed) {
			return redirect()->action('survey.finish');
		}

		return view('survey.index', [
			'student' => $this->student,
			'questionnaireUrl' => $this->getNextQuestionnaireUrl(),
		]);
	}

	public function questionnaire (Teacher $teacher)
	{
		$student = $this->student;
		$questionnaire = $student->questionnaires()->where('teacher_id', '=', $teacher->id)->first();

		$questions = Question::all();
		$answers = $questionnaire->answers->keyBy('question_id');
		$statistics = $student->getSurveyStatistics();

		return view(
			'survey.questionnaire',
			compact('questionnaire', 'teacher', 'student', 'questions', 'answers', 'statistics')
		);
	}

	public function saveQuestionnaire(Request $request)
	{
		$questionnaire = $this->student->questionnaires()->find($request->input('questionnaire_id'));

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

		return redirect($this->getNextQuestionnaireUrl());
	}

	public function finish()
	{
		return view('survey.finish');
	}

	public function restart(Request $request, Student $student)
	{
		if($request->input('restart')) {
			/** @var Questionnaire $questionnaire */
			foreach($this->student->questionnaires as $questionnaire)
			{
				$questionnaire->is_completed = false;
				$questionnaire->save();
			}
		}

		return redirect($this->getNextQuestionnaireUrl());
	}

	protected function getNextQuestionnaireUrl () {
		$questionnaire = $this->student->getFirstNotCompletedQuestionnaire();

		if($questionnaire) {
			return URL::route('survey.questionnaire', [$questionnaire->teacher]);
		} else {
			return URL::route('survey.finish');
		}
	}
}
