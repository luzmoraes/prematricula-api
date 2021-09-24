<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Responsible;
use Illuminate\Http\Request;

class ResponsiblesController extends Controller
{
    public function show(Request $request, $id)
    {
        return Responsible::find($id);
    }

    public function search(Request $request) {
        return Responsible::where('cpf', $request->get('cpf'))->first();
    }
}
