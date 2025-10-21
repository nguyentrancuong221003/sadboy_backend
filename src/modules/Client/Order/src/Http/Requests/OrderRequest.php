<?php

namespace Modules\Client\Order\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
            'code' => ['required', 'string', 'min:10'],
            'name' => ['required', 'string'],
            'date_delivery' => ['required', 'date'],
            'products' => ['required', 'array'],
            'status' => ['nullable'],
            'count' => ['required', 'integer'],
            'total' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'address' => ['required', 'string'],
            'pay' => ['required', 'string'],
            'subtotal' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],

        ];
    }

    public function messages() {
        return [
            'required' => __('Client/Order::Validation.required'),
            'string' => __('Client/Order::Validation.string'),
            'min' =>  __('Client/Order::Validation.min'),
            'array' => __('Client/Order::Validation.array'),
            'integer' =>  __('Client/Order::Validation.integer'),
            'max' => __('Client/Order::Validation.max'),
            'date' => __('Client/Order::Validation.date'),
            'numeric' => __('Client/Order::Validation.numeric'),

        ];
    }

    public function attributes(){
        return [
            'code' =>  __('Client/Order::Validation.attributes.code'),
            'name' =>  __('Client/Order::Validation.attributes.name'),
            'date_delivery' =>  __('Client/Order::Validation.attributes.date_delivery'),
            'products' =>  __('Client/Order::Validation.attributes.products'),
            'status' =>  __('Client/Order::Validation.attributes.status'),
            'count' =>  __('Client/Order::Validation.attributes.count'),
            'total' =>  __('Client/Order::Validation.attributes.total'),
            'address' =>  __('Client/Order::Validation.attributes.address'),
            'pay' =>  __('Client/Order::Validation.attributes.pay'),
            'subtotal' =>  __('Client/Order::Validation.attributes.subtotal'),
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
