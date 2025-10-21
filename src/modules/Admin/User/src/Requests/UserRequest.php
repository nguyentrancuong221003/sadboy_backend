<?php

namespace Modules\Admin\User\src\Requests;
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
        $id = $this->route('id'); // Nếu route là /user/{id}
        $isUpdate = in_array($this->method(), ['PUT', 'PATCH']);

        return [
            'code' => $isUpdate
                ? ['nullable', 'min:10', Rule::unique('users', 'code')->ignore($id)]
                : ['required', 'min:10', Rule::unique('users', 'code')]
            ,
            'name' => $isUpdate
                ? ['nullable', 'min:5']
                : ['required', 'min:5'],
            'email' => $isUpdate
                ? ['nullable', 'email',  Rule::unique('users', 'email')->ignore($id)]
                : ['required', 'email',  Rule::unique('users', 'email')],
            'img' => 'nullable|file|image|max:2048',
            'phone' => $isUpdate
                ? ['nullable', 'regex:/^[0-9]{10,11}$/', Rule::unique('users', 'phone')->ignore($id)]
                : ['nullable', 'regex:/^[0-9]{10,11}$/', Rule::unique('users', 'phone')],
            'gender' => 'nullable',
            'password' => $isUpdate
                ? ['nullable', Password::min(8)->letters()->mixedCase()->numbers()->symbols()]
                : ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'status' => 'nullable',
            'date_birth' => ['nullable', 'date'],
            'date_create_account' => ['nullable', 'date'],
            'money_spend' => ['nullable', 'numeric'],
            'type' => ['nullable'],
            'number_carts' => ['nullable', 'integer'],
            'total_order' => ['nullable', 'integer'],
            'total_order_cancel' => ['nullable', 'integer'],
            'total_order_success' => ['nullable', 'integer'],
            'comment_count' => ['nullable', 'integer'],

        ];
    }

    public function messages() {
        return [
            'required' => __('Admin/User::Validation.required'),
            'email' => __('Admin/User::Validation.email'),
            'file' =>  __('Admin/User::Validation.file'),
            'min' =>  __('Admin/User::Validation.min'),
            'image' =>  __('Admin/User::Validation.image'),
            'max' => __('Admin/User::Validation.max'),
            'confirmed' => __('Admin/User::Validation.confirmed'),
            'date' => __('Admin/User::Validation.date'),
            'numeric' => __('Admin/User::Validation.numeric'),
            'integer' => __('Admin/User::Validation.integer'),
        ];
    }

    public function attributes(){
        return [
            'code' =>  __('Admin/User::Validation.attributes.code'),
            'name' => __('Admin/User::Validation.attributes.name'),
            'email' => __('Admin/User::Validation.attributes.email'),
            'img' => __('Admin/User::Validation.attributes.img'),
            'phone' => __('Admin/User::Validation.attributes.phone'),
            'gender' => __('Admin/User::Validation.attributes.gender'),
            'password' => __('Admin/User::Validation.attributes.password'),
            'status' => __('Admin/User::Validation.attributes.status'),
            'date_birth' => __('Admin/User::Validation.attributes.date_birth'),
            'date_create_account' => __('Admin/User::Validation.attributes.date_create_account'),
            'money_spend' => __('Admin/User::Validation.attributes.money_spend'),
            'type' => __('Admin/User::Validation.attributes.type'),
            'number_carts' => __('Admin/User::Validation.attributes.number_carts'),
            'total_order' => __('Admin/User::Validation.attributes.total_order'),
            'total_order_cancel' => __('Admin/User::Validation.attributes.total_order_cancel'),
            'total_order_success' => __('Admin/User::Validation.attributes.total_order_success'),
            'comment_count' => __('Admin/User::Validation.attributes.comment_count'),
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
