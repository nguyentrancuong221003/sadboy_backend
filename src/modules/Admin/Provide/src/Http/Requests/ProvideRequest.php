<?php

namespace Modules\Admin\Provide\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class ProvideRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id'); // Nếu route là /employee/{id}
        $isUpdate = in_array($this->method(), ['PUT', 'PATCH']);

        return [
            'code' => $isUpdate
                ? ['nullable', 'min:10', Rule::unique('provides', 'code')->ignore($id)]
                : ['required', 'min:10', Rule::unique('provides', 'code')]
            ,
            'name' => $isUpdate
                ? ['nullable', 'min:5', 'string']
                : ['required', 'min:5', 'string']
            ,
            'phone' => $isUpdate
                ? ['nullable', 'regex:/^[0-9]{10,11}$/', Rule::unique('provides', 'phone')->ignore($id)]
                : ['required', 'regex:/^[0-9]{10,11}$/', Rule::unique('provides', 'phone')]
            ,
            'address' => $isUpdate
                ? ['nullable', 'min:5', 'string']
                : ['required', 'min:5', 'string']
            ,
            'email' => $isUpdate
                ? ['nullable', 'email',  Rule::unique('provides', 'email')->ignore($id)]
                : ['required', 'email',  Rule::unique('provides', 'email')]
            ,
            'img' => ['nullable', 'file', 'image', 'max:2048'],
            'note' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
            'total_order' => ['nullable', 'integer'],
            'return_order' => ['nullable', 'integer'],
            'total_buy' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/'],
            'total_debt' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/'],
            'bank' => ['nullable', 'string'],
            'account_name' => ['nullable', 'string'],
            'account_phone' => ['nullable', 'string'],
            'qr_img' => ['nullable', 'string'],

        ];
    }

    public function messages() {
        return [
            'required' => __('Admin/Provide::Validation.required'),
            'email' => __('Admin/Provide::Validation.email'),
            'date' => __('Admin/Provide::Validation.email'),
            'integer' => __('Admin/Provide::Validation.integer'),
            'numeric' => __('Admin/Provide::Validation.numeric'),
            'unique' => __('Admin/Provide::Validation.unique'),
            'string' => ('Admin/Provide::Validation.string'),
            'min' => __('Admin/Provide::Validation.min'),
            'file' => __('Admin/Provide::Validation.file'),
            'image' => __('Admin/Provide::Validation.image'),
            'max' => __('Admin/Provide::Validation.max'),
            'exists' => __('Admin/Provide::Validation.exists'),
            'json' => __('Admin/Provide::Validation.json'),
            'array' => __('Admin/Provide::Validation.array'),
            'decimal' => __('Admin/Provide::Validation.decimal'),

        ];
    }

    public function attributes(){
        return [
            'code' =>  __('Admin/Employee::Validation.attributes.code'),
            'name' =>  __('Admin/Employee::Validation.attributes.name'),
            'phone' =>  __('Admin/Employee::Validation.attributes.phone'),
            'address' =>  __('Admin/Employee::Validation.attributes.address'),
            'email' =>  __('Admin/Employee::Validation.attributes.email'),
            'img' =>  __('Admin/Employee::Validation.attributes.img'),
            'note' =>  __('Admin/Employee::Validation.attributes.note'),
            'status' =>  __('Admin/Employee::Validation.attributes.status'),
            'total_order' =>  __('Admin/Employee::Validation.attributes.total_order'),
            'return_order' =>  __('Admin/Employee::Validation.attributes.return_order'),
            'total_buy' =>  __('Admin/Employee::Validation.attributes.total_buy'),
            'total_debt' =>  __('Admin/Employee::Validation.attributes.total_debt'),
            'bank' =>  __('Admin/Employee::Validation.attributes.bank'),
            'account_name' =>  __('Admin/Employee::Validation.attributes.account_name'),
            'account_phone' =>  __('Admin/Employee::Validation.attributes.account_phone'),
            'qr_img' =>  __('Admin/Employee::Validation.attributes.qr_img'),
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
