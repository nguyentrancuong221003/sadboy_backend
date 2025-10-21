<?php

namespace Modules\Client\Account\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class UserRequest extends FormRequest
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
        $user = auth()->guard('user')->user() ?? null;
        $id = $user?->id;
        $isUpdate = in_array($this->method(), ['PUT', 'PATCH']);

        return [
            'name' => $isUpdate
                ? ['nullable', 'string', 'min:10']
                : ['required', 'string', 'min:8'],

            'email' => $isUpdate
                ? ['nullable', 'email', Rule::unique('users', 'email')->ignore($id)]
                : ['required', 'email', Rule::unique('users', 'email')],

            'password' => $isUpdate
                ? ['nullable', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()]
                : ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],

            'password_confirmation' => $isUpdate
                ? ['nullable', 'same:password']
                : ['required', 'same:password'],
        ];
    }

    public function messages() {
        return [
            'required' => __('Client/Account::Validation.required'),
            'email' => __('Client/Account::Validation.email'),
            'string' =>  __('Client/Account::Validation.string'),
            'min' =>  __('Client/Account::Validation.min'),
            'same' =>  __('Client/Account::Validation.same'),
            'confirmed' => __('Client/Account::Validation.confirmed'),
        ];
    }

    public function attributes(){
        return [
            'name' => __('Client/Account::Validation.attributes.name'),
            'email' => __('Client/Account::Validation.attributes.email'),
            'password' => __('Client/Account::Validation.attributes.password'),
            'password_confirmation' => __('Client/Account::Validation.attributes.password_confirmation'),

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
