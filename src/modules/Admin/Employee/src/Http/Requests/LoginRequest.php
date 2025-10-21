<?php

namespace Modules\Admin\Employee\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
class LoginRequest extends FormRequest
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
        return [
            'password' => [
                'required',
                'string',
                'min:8',
                'max:64',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
            'email' => ['required', 'email', 'max:255'],
        ];
    }

    public function messages() {
        return [
            'required' => __('Admin/Employee::Validation.required'),
            'email' => __('Admin/Employee::Validation.email'),
            'string' => __('Admin/Employee::Validation.string'),
            'min' => __('Admin/Employee::Validation.min'),
            'max' => __('Admin/Employee::Validation.max'),
            'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.',
        ];
    }

    public function attributes(){
        return [
            'email' => __('Admin/Employee::Validation.attributes.email'),
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
