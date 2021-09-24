<?php

namespace App\Http\Requests\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FinancialResponsibleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'cpf' => [
                'required',
                'max:11',
                Rule::unique('financial_responsibles')
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('financial_responsibles')
            ],
        ];
    }
}
