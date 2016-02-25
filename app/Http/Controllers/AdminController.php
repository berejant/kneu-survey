<?php


namespace Kneu\Survey\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kneu\Survey\Question;
use Kneu\Survey\Result;
use Kneu\Survey\Teacher;


class AdminController extends Controller
{
    public function showList () {

        $teachers = Teacher::select('teachers.*', 'teacher_results.count')
            ->join('teacher_results', function($join) {
                $join->on('teachers.id', '=', 'teacher_results.teacher_id')
                    ->where('teacher_results.type', '=', 'fill');
            })
            ->orderBy('count', 'DESC')
            ->get();

        return view(
            'admin.list', [
                'teachers' => $teachers
            ]
        );
    }

    public function teacher (Teacher $teacher)
    {
        $semesters = [];
        $teacherResults = [];
        $questions = [];

        /** @var TeacherResult $result */
        foreach($teacher->teacherResults as $result)
        {
            $semesterKey = $result->academic_year . '-' . $result->semester;

            if(!isset($semesters[$semesterKey])) {
                $semester = new \stdClass();
                $semester->academic_year = $result->academic_year;
                $semester->semester = $result->semester;

                $semesters[$semesterKey] = $semester;
            }

            $teacherResults[$result->type][$semesterKey] = $result;
        }
        ksort($semesters);

        /** @var QuestionResult $result */
        foreach($teacher->questionResults as $result)
        {
            $semesterKey = $result->academic_year . '-' . $result->semester;

            $question = $result->question;

            if(!isset($questions[$question->id])) {
                $questions[$question->id] = [
                    'question' => $question,
                    'results' => []
                ];
            }

            $choiceOptionId = $result->question_choice_option_id ?: 'null';
            $questions[$question->id]['results'][$choiceOptionId][$semesterKey] = $result;
        }
        ksort($questions);


        $textQuestions = Question::whereType('text')->get();
        $textAnswers = [];

        /** @var Question $question */
        foreach($textQuestions as $index => $question)
        {
            $textAnswers[ $question->id ] = $question->answers()->whereExists(function ($query) use($teacher) {
                $query->select(DB::raw(1))
                    ->from('questionnaires')
                    ->whereRaw('questionnaires.id = answers.questionnaire_id')
                    ->whereTeacherId($teacher->id);
            })->get();
        }

        return view(
            'admin.teacher',
            compact(
                'teacher', 'teacherResults',
                'semesters', 'questions',
                'textQuestions', 'textAnswers'
            )
        );
    }
}