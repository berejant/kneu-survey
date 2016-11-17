<?php


namespace Kneu\Survey\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kneu\Survey\Answer;
use Kneu\Survey\Question;
use Kneu\Survey\Result;
use Kneu\Survey\Teacher;


class AdminController extends Controller
{
    public function showList () {

        $teachers = Teacher::select('teachers.*', 'teacher_results.count')
            ->join('teacher_results', function($join) {
                $join->on('teachers.id', '=', 'teacher_results.teacher_id')
                    ->where('teacher_results.type', '=', 'fill')
                    ->where('teacher_results.academic_year', '=', config('academic.year'))
                    ->where('teacher_results.semester', '=', config('academic.semester'));
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
            $_answers = $question->answers()
                ->with('questionnaire')
                ->whereHas('questionnaire', function($query) use ($teacher) {
                    $query->whereTeacherId($teacher->id);
                })
                ->get();

            $textAnswers[$question->id] = [];

            /** @var Answer $answer */
            foreach ($_answers as $answer) {
                $semesterKey = $answer->questionnaire->academic_year . '-' . $answer->questionnaire->semester;
                $textAnswers[$question->id][$semesterKey][] = $answer;
            }

            if (!$textAnswers[$question->id]) {
                unset($textQuestions[$index], $textAnswers[$question->id]);
            }
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

    public function launchStatus(Application $app)
    {
        $client = $app->make('JournalApiClient');

        $status = false;
        $error = null;

        $semesters = [];

        try {
            $response = $client->get('launch.json');
            $answer = json_decode($response->getBody(), true);

            if (isset($answer['status'])) {
                $status = (bool)$answer['status'];
            }

            if (isset($answer['semesters']) && is_array($answer['semesters'])) {
                $pattern = '%d-%d - %d семестр';
                foreach ($answer['semesters'] as $semester) {
                    $key = $semester['year'] . '-' . $semester['number'];
                    $semesters[$key] = sprintf(
                        $pattern, $semester['year'], $semester['year'] + 1, $semester['number']
                    );
                }

            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        $semesterSelected = config('academic.year') . '-' . config('academic.semester');

        return view(
            'admin.launchStatus',
            compact(
                'status', 'semesters', 'semesterSelected'
            )
        );
    }

    public function launchChangeStatus(Application $app, Request $request)
    {
        try {
            $status = $request->has('status') ? (bool) $request->input('status') : abort(402);
            $selectedSemesterKey = $request->input('semester');

            $client = $app->make('JournalApiClient');
            $response = $client->post('launch.json', [
                'form_params' => [
                    'status' => $status,
                ],
            ]);
            $answer = json_decode($response->getBody(), true);

            if(!isset($answer['status']) || $answer['status'] !== $status) {
                throw new \Exception('Не вдалось оновити статус');
            }

            if (isset($answer['semesters']) && is_array($answer['semesters'])) {
                $selectedSemester = reset($answer['semesters']);
                foreach ($answer['semesters'] as $semester) {
                    $key = $semester['year'] . '-' . $semester['number'];
                    if($selectedSemesterKey === $key) {
                        $selectedSemester = $semester;
                        break;
                    }
                }
            } else {
                throw new \Exception('Не отримано перелік семестрів');
            }

            $env = 'ACADEMIC_YEAR=' . $selectedSemester['year'] . PHP_EOL
                 . 'ACADEMIC_SEMESTER=' . $selectedSemester['number'] . PHP_EOL;

            $written = file_put_contents($app->basePath() . '/.academic.env', $env);

            if(!$written) {
                throw new \Exception('Не вдалось записати файл .academic.env');
            }

            $class = substr(self::class, strlen(__NAMESPACE__) + 1);
            if($status) {
                $redirect = redirect()->action($class . '@launchChangeStatusFinish')->with('launchChangeStatus', $status);
            } else {
                $redirect = redirect()->action($class . '@launchStatus');
            }

            // Artisan::call портит base_uri, поэтому redirect нужно вызывать раньше
            Artisan::call('config:cache');

            return $redirect;
        } catch (\Exception $e) {
            return view('admin.launchError', [
                'error' => $e->getMessage(),
            ]);
        }

    }

    protected function launchChangeStatusFinish(Application $app, Request $request)
    {
        $status = session('launchChangeStatus');

        if(null === $status) {
            return abort(402);
        }

        $class = substr(self::class, strlen(__NAMESPACE__) + 1);
        $redirect = redirect()->action($class . '@launchStatus');

        if($status) {
            Artisan::call('import');
        }

        try {
            $app->make('JournalApiClient')->get('sync.php');
        } catch(\Exception $e) {
            // ошибки не важны - задача если че по cron-у запустится
        }

        return $redirect;
    }
}