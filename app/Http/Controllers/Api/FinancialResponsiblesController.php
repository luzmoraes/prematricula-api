<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FinancialResponsible;
use Illuminate\Http\Request;

class FinancialResponsiblesController extends Controller
{
    public function show(Request $request, $id)
    {
        return FinancialResponsible::find($id);
    }

    public function search(Request $request) {
        return FinancialResponsible::where('cpf', $request->get('cpf'))->first();
    }
}
