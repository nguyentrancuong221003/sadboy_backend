<?php

namespace Modules\Admin\Order\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //return auth()->user() && auth()->user()->role === 'admin'; admin phải đăng nhập
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
                ? ['nullable']
                : ['nullable', 'min:5']
            ,
            'date_delivery' => $isUpdate
                ? ['nullable']
                : ['required', 'date']
            ,
            'products' => $isUpdate
                ? ['nullable']
                : ['required']
            ,
            'status' => ['nullable'],
            'count' => $isUpdate
                ? ['nullable', 'integer']
                : ['required', 'integer']
            ,
            'total' => $isUpdate
                ? ['nullable', 'decimal:0,2']
                : ['required', 'decimal:0,2']
            ,
            'address' => $isUpdate
                ? ['nullable']
                : ['required']
            ,
            'pay' => $isUpdate
                ? ['nullable']
                : ['required']
            ,
            'discount_code' => ['nullable'],
            'unit_shipping' => ['nullable'],
            'note' => ['nullable'],
            'note_cancel' => ['nullable'],
            'subtotal' => $isUpdate
                ? ['nullable', 'decimal:0,2']
                : ['required', 'decimal:0,2'],
            'money_discount' => ['nullable'],
            'money_ship' => ['nullable'],
            'paid' => ['nullable']

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
