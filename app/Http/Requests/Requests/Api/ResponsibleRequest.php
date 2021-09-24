<?php

namespace App\Http\Requests\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResponsibleRequest extends FormRequest
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
            'cpf' => [
                'required',
                'max:11',
                Rule::unique('responsibles')
            ],
            'rg' => [
                'max:15',
                Rule::unique('responsibles')
            ],
            'relationship' => 'required|max:15',
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('responsibles')
            ],
            'cep' => 'required|max:8',
            'address' => 'required|max:255',
            'number' => 'required|max:10',
            'neighborhood' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:2',
            'complement' => 'max:255',
            'nationality' => 'required|max:255',
            'profession' => 'required|max:255',
        ];
    }
}
