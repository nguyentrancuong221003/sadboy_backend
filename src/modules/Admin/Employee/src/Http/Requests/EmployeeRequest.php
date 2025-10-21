<?php

namespace Modules\Admin\Employee\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id'); // Nếu route là /employee/{id}
        $isUpdate = in_array($this->method(), ['PUT', 'PATCH']);

        return [
            'code' => $isUpdate
                ? ['nullable', 'min:10', Rule::unique('employees', 'code')->ignore($id)]
                : ['required', 'min:10', Rule::unique('employees', 'code')]
            ,
            'name' => $isUpdate
                ? ['nullable', 'min:5']
                : ['required', 'min:5'],
            'gender' => $isUpdate
                ? ['nullable']
                : ['required'],
            'date_birth' => $isUpdate
                ? ['nullable', 'date']
                : ['required', 'date'],
            'phone' => $isUpdate
                ? ['nullable', 'regex:/^[0-9]{10,11}$/', Rule::unique('employees', 'phone')->ignore($id)]
                : ['required', 'regex:/^[0-9]{10,11}$/', Rule::unique('employees', 'phone')],
            'email' => $isUpdate
                ? ['nullable', 'email',  Rule::unique('employees', 'email')->ignore($id)]
                : ['required', 'email',  Rule::unique('employees', 'email')],
            'address' =>  $isUpdate
                ? ['nullable','min:15']
                : ['required', 'min:15'],
            'diploma' => 'nullable',
            'status' => 'nullable',
            'position_id' => $isUpdate
                ? ['nullable', 'integer']
                : ['required', 'integer'],
            'department_id' => $isUpdate
                ? ['nullable', 'integer']
                : ['required', 'integer'],
            'date_start_work' => $isUpdate
                ? ['nullable', 'date']
                : ['required','date'],
            'contrast_id' => $isUpdate
                ? ['nullable', 'integer']
                : ['required', 'integer'],
            'work_shift_id' => $isUpdate
                ? ['nullable', 'integer']
                : ['required', 'integer'],
            'salary' => $isUpdate
                ? ['nullable', 'numeric']
                : ['required', 'numeric'],
            'grant_id' => $isUpdate
                ? ['nullable', 'integer']
                : ['required', 'integer'],
            'img' => 'nullable|file|image|max:2048',
            'password' => $isUpdate
                ? ['nullable']
                : ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ];
    }

    public function messages() {
        return [
            'required' => __('Admin/Employee::Validation.required'),
            'email' => __('Admin/Employee::Validation.email'),
            'min' => __('Admin/Employee::Validation.min'),
            'date' => __('Admin/Employee::Validation.date'),
            'integer' => __('Admin/Employee::Validation.integer'),
            'numeric' => __('Admin/Employee::Validation.numeric'),
            'file' => __('Admin/Employee::Validation.file'),
            'image' => __('Admin/Employee::Validation.image'),
            'max' => __('Admin/Employee::Validation.max'),
            'password' =>  __('Admin/Employee::Validation.password'),
            'regex' => __('Admin/Employee::Validation.regex'),
            'unique' => __('Admin/Employee::Validation.unique'),
        ];
    }

    public function attributes(){
        return [
            'code' =>  __('Admin/Employee::Validation.attributes.code'),
            'name' => __('Admin/Employee::Validation.attributes.name'),
            'gender' => __('Admin/Employee::Validation.attributes.gender'),
            'date_birth' => __('Admin/Employee::Validation.attributes.date_birth'),
            'phone' => __('Admin/Employee::Validation.attributes.phone'),
            'email' => __('Admin/Employee::Validation.attributes.email'),
            'address' => __('Admin/Employee::Validation.attributes.address'),
            'diploma' => __('Admin/Employee::Validation.attributes.diploma'),
            'status' => __('Admin/Employee::Validation.attributes.status'),
            'position_id' => __('Admin/Employee::Validation.attributes.position_id'),
            'department_id' => __('Admin/Employee::Validation.attributes.department_id'),
            'date_start_work' => __('Admin/Employee::Validation.attributes.date_start_work'),
            'contrast_id' => __('Admin/Employee::Validation.attributes.contrast_id'),
            'work_shift_id' => __('Admin/Employee::Validation.attributes.work_shift_id'),
            'salary' => __('Admin/Employee::Validation.attributes.salary'),
            'grant_id' => __('Admin/Employee::Validation.attributes.grant_id'),
            'img' => __('Admin/Employee::Validation.attributes.img'),
            'password' => __('Admin/Employee::Validation.attributes.password'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'statusCode'=> 422,
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422));
    }
}
