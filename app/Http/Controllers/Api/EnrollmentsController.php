<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Enrollment;
use App\Models\FinancialResponsible;
use App\Models\Responsible;
use App\Models\ResponsibleStudent;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EnrollmentsController extends Controller
{
    public function store(Request $request)
    {

        $validatorResponsible = $this->validatorResponsible($request->get('responsible'));

        if ($validatorResponsible->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'responsible_invalid_date',
                'errors' => $validatorResponsible->errors()
            ]);
        }

        $validatorStudent = $this->validatorStudent($request->get('student'));

        if ($validatorStudent->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'student_invalid_date',
                'errors' => $validatorStudent->errors()
            ]);
        }

        $validatorFinancialResponsible = $this->validatorFinancialResponsible($request->get('financial_responsible'));

        if ($validatorFinancialResponsible->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'financial_responsible_invalid_date',
                'errors' => $validatorFinancialResponsible->errors()
            ]);
        }

        try {
            
            $requestResponsible = $request->get('responsible');
            $requestStudent = $request->get('student');
            $requestFinancialResponsible = $request->get('financial_responsible');

            // Responsible request
            if (isset($requestResponsible['id'])) {
                $responsible = Responsible::find($requestResponsible['id']);
            } else {
                $responsible = new Responsible($requestResponsible);
                $responsible->save();
            }

            // Student request
            if (isset($requestStudent['id'])) {
                $student = Student::find($requestStudent['id']);
            } else {
                $student = new Student($requestStudent);
                $student->save();
            }

            // Financial Responsible request
            if (isset($requestFinancialResponsible['id'])) {
                $financialResponsible = FinancialResponsible::find($requestFinancialResponsible['id']);
            } else {
                $financialResponsible = new FinancialResponsible($requestFinancialResponsible);
                $financialResponsible->save();
            }

            $enrollmentsYear = $request->has('year') 
                ? (int) $request->get('year')
                : enrollmentsYear();

            $responsibleStudent = ResponsibleStudent::where('responsible_id', $responsible->id)
                                    ->where('student_id', $student->id)
                                    ->first();

            if (!$responsibleStudent) {
                $responsibleStudent = new ResponsibleStudent([
                    'responsible_id' => $responsible->id,
                    'student_id' => $student->id,
                    'relationship' => $requestResponsible['relationship']
                ]);
                $responsibleStudent->save();
            }

            $enrollment = Enrollment::where('student_id', $student->id)
                            ->where('year', $enrollmentsYear)
                            ->first();

            if ($enrollment) {
                return response()->json([
                    'success' => false, 
                    'message' => 'O aluno já está matriculado para o ano de ' . $enrollmentsYear . '.'
                ]);
            } else {
                $enrollment = new Enrollment([
                    'student_id' => $student->id,
                    'responsible_id' => $responsible->id,
                    'class' => $requestStudent['class'],
                    'year' => $enrollmentsYear,
                    'status' => Enrollment::STATUS_STARTED
                ]);
                $enrollment->save();
            }


        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'error' => $e->getMessage(),
                'message' => 'Erro ao realizar a matricula, tente novamente mais tarde.'
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Matrícula realizada com sucesso.']);
    }

    protected function validatorResponsible(array $data)
    {
        $messages = [
            'cpf.required' => 'O CPF do responsável é obrigatório',
            'cpf.max' => 'O CPF do responsável deve ter no máximo 11 caracteres',
            'cpf.unique' => 'O CPF do responsável já está cadastrado',
            'rg.max' => 'O RG do responsável deve ter no máximo 11 caracteres',
            'rg.unique' => 'O RG do responsável já está cadastrado',
            'relationship.required' => 'O relacionamento do responsável com o aluno é obrigatório',
            'relationship.max' => 'O relacionamento do responsável com o aluno deve ter no máximo 15 caracteres',
            'name.required' => 'O nome do responsável é obrigatório',
            'name.max' => 'O nome do responsável deve ter no máximo 255 caracteres',
            'email.required' => 'O email do responsável é obrigatório',
            'email.email' => 'O email do responsável tá inválido',
            'email.max' => 'O email do responsável deve ter no máximo 255 caracteres',
            'email.unique' => 'O email do responsável já existe',
            'cep.required' => 'O CEP do responsável é obrigatório',
            'cep.max' => 'O CEP do responsável deve ter no máximo 8 caracteres',
            'address.required' => 'O endereço do responsável é obrigatório',
            'address.max' => 'O endereço do responsável deve ter no máximo 255 caracteres',
            'number.required' => 'O número do responsável é obrigatório',
            'number.max' => 'O número do responsável deve ter no máximo 10 caracteres',
            'neighborhood.required' => 'O bairro do responsável é obrigatório',
            'neighborhood.max' => 'O bairro do responsável deve ter no máximo 255 caracteres',
            'city.required' => 'A cidade do responsável é obrigatória',
            'city.max' => 'A cidade do responsável deve ter no máximo 255 caracteres',
            'state.required' => 'O estado do responsável é obrigatório',
            'state.max' => 'O estado do responsável deve ter no máximo 2 caracteres',
            'complement.max' => 'O complemento do responsável deve ter no máximo 255 caracteres',
            'nationality.required' => 'A nacionalidade do responsável é obrigatória',
            'nationality.max' => 'A nacionalidade do responsável deve ter no máximo 255 caracteres',
            'profession.required' => 'A profissão do responsável é obrigatória',
            'profession.max' => 'A profissão do responsável deve ter no máximo 255 caracteres'
        ];

        return Validator::make($data, [
            'cpf' => [
                'required',
                'max:11',
                isset($data['id'])
                    ? Rule::unique('responsibles')->ignore($data['id'])
                    : Rule::unique('responsibles')
            ],
            'rg' => [
                'max:15',
                isset($data['id'])
                    ? Rule::unique('responsibles')->ignore($data['id'])
                    : Rule::unique('responsibles'),
                'nullable'
            ],
            'relationship' => 'required|max:15',
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                isset($data['id'])
                    ? Rule::unique('responsibles')->ignore($data['id'])
                    : Rule::unique('responsibles')
            ],
            'cep' => 'required|max:8',
            'address' => 'required|max:255',
            'number' => 'required|max:10',
            'neighborhood' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:2',
            'complement' => 'max:255|nullable',
            'nationality' => 'required|max:255',
            'profession' => 'required|max:255'
        ], $messages);
    }

    protected function validatorStudent(array $data)
    {
        $messages = [
            'name.required' => 'O nome do aluno é obrigatório',
            'name.max' => 'O nome do aluno deve ter no máximo 255 caracteres',
            'cpf.max' => 'O CPF do responsável deve ter no máximo 11 caracteres',
            'cpf.unique' => 'O CPF do responsável já está cadastrado',
            'birthday.required' => 'A data de nascimento do aluno é obrigatória',
            'blood_type.max' => 'O tipo sanguineo deve ter no máximo 3 caracteres',
            'race_color' => 'A raça/cor deve ter no máximo 15 caracteres',
            'allergic_description.required' => 'A descrição da alergia é obrigatória',
            'allergic_description.max' => 'A descrição da alergia deve ter no máximo 255 caracteres',
            'cep.required' => 'O CEP do responsável é obrigatório',
            'cep.max' => 'O CEP do responsável deve ter no máximo 8 caracteres',
            'address.required' => 'O endereço do responsável é obrigatório',
            'address.max' => 'O endereço do responsável deve ter no máximo 255 caracteres',
            'number.required' => 'O número do responsável é obrigatório',
            'number.max' => 'O número do responsável deve ter no máximo 10 caracteres',
            'neighborhood.required' => 'O bairro do responsável é obrigatório',
            'neighborhood.max' => 'O bairro do responsável deve ter no máximo 255 caracteres',
            'city.required' => 'A cidade do responsável é obrigatória',
            'city.max' => 'A cidade do responsável deve ter no máximo 255 caracteres',
            'state.required' => 'O estado do responsável é obrigatório',
            'state.max' => 'O estado do responsável deve ter no máximo 2 caracteres',
            'complement.max' => 'O complemento do responsável deve ter no máximo 255 caracteres',
            'father_name.required' => 'O nome do pai é obrigatório',
            'father_name.max' => 'O nome do pai deve ter no máximo 255 caracteres',
            'father_phone.max' => 'O telefone do pai deve ter no máximo 15 caracteres',
            'mother_name.required' => 'O nome da mãe é obrigatório',
            'mother_name.max' => 'O nome da mãe deve ter no máximo 255 caracteres',
            'mother_phone.max' => 'O telefone da mãe deve ter no máximo 15 caracteres',
            'authorized_responsibilities.max' => 'Os responsáveis autorizados deve ter no máximo 255 caracteres'
        ];

        return Validator::make($data, [
            'name' => 'required|max:255',
            'cpf' => [
                'max:11',
                isset($data['id'])
                    ? Rule::unique('students')->ignore($data['id'])
                    : Rule::unique('students')
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
        ], $messages);
    }

    protected function validatorFinancialResponsible(array $data)
    {
        $messages = [
            'name.required' => 'O nome do responsável financeiro é obrigatório',
            'name.max' => 'O nome do responsável financeiro deve ter no máximo 255 caracteres',
            'cpf.required' => 'O CPF do responsável financeiro é obrigatório',
            'cpf.max' => 'O CPF do responsável financeiro deve ter no máximo 11 caracteres',
            'cpf.unique' => 'O CPF do responsável financeiro já está cadastrado',
            'email.required' => 'O email do responsável financeiro é obrigatório',
            'email.email' => 'O email do responsável financeiro tá inválido',
            'email.max' => 'O email do responsável financeiro deve ter no máximo 255 caracteres',
            'email.unique' => 'O email do responsável financeiro já existe',
        ];

        return Validator::make($data, [
            'name' => 'required|max:255',
            'cpf' => [
                'required',
                'max:11',
                isset($data['id'])
                    ? Rule::unique('financial_responsibles')->ignore($data['id'])
                    : Rule::unique('financial_responsibles')
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                isset($data['id'])
                    ? Rule::unique('financial_responsibles')->ignore($data['id'])
                    : Rule::unique('financial_responsibles')
            ],
        ], $messages);
    }

}
