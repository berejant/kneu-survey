<?php namespace Kneu\Survey\Http\Controllers;

use Kneu\Survey\Http\Requests;
use Kneu\Survey\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Kneu\Survey\Questionnaire;
use Kneu\Survey\Student;
use Kneu\Survey\Teacher;

class SurveyController extends Controller {

	public function __construct()
	{
		$this->middleware('Kneu\Survey\Http\Middleware\StudentAuth');
	}

	/**
	 * @var Student $student
	 * @return Response
	 */
	public function getIndex(Student $student)
	{
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
				'student' => $student,
				'secret' => $student->getSecret()
			]);
		}

		return view('quuestionnaire', ['student' => $student]);
	}

	public function getFinish(Student $student)
	{
		return view('finish', ['student' => $student]);
	}
}
