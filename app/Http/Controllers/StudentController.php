<?php

namespace Kneu\Survey\Http\Controllers;

use Illuminate\Http\Request;
use Kneu\Survey\Student;
use Illuminate\Support\Facades\Response;

class StudentController extends Controller
{
    /**
     * @param Request $request
     * @param Student $student
     * @param string $secret
     * @return Response
     */
    public function auth(Request $request, Student $student, $secret)
    {
        if( $student->getSecret() === $secret) {
            $request->session()->put('studentId', $student->id);
            return redirect()->route('survey.start');
        }

        return abort(401);
    }

    public function notCompletedJson ()
    {
        $ids = Student::where('is_completed', '=', false)->lists('id');
        return Response::json($ids);
    }
}