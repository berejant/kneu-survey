<?php

namespace Kneu\Survey\Http\Controllers;

use Illuminate\Http\Request;
use Kneu\Survey\Student;
use Symfony\Component\HttpFoundation\Response;

class StudentAuthController extends Controller
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
}