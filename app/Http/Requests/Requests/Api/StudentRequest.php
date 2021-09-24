<?php

namespace App\Http\Requests\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
                Rule::unique('students')
            ],
            'birthday' => 'required',
            'blood_type' => 'max:3',
            'race_color' => 'max:15',
            'allergic_description' => 'required_if:allergic,==,true|max:255',
            'cep' => 'required|max:8',
            'address' => 'required|max:255',
            'number' => 'required|max:10',
            'neighborhood' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:2',
            'complement' => 'max:255',
            'father_name' => 'required|max:255',
            'father_phone' => 'required|max:15',
            'mother_name' => 'required|max:255',
            'mother_phone' => 'required|max:15',
            'authorized_responsibilities' => 'max:255',
        ];
    }
}
