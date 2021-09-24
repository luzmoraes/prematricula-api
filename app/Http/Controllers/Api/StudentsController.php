<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function show(Request $request, $id)
    {
        return Student::find($id);
    }

    public function search(Request $request)
    {
        $cpf = $request->get('cpf');
        $name = $request->get('name');

        $student = Student::where('name', $name);

        if ($cpf) {
            $student->orWhere('cpf', $cpf);
        }
            
        return $student->first();
    }

    public function searchForPartOfName(Request $request)
    {
        $name = $request->get('name');

        if (!$name) {
            return [];
        }

        return Student::where('name', 'like', '%' . $name . '%')->get();
    }
}
