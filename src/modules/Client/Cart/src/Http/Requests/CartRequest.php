<?php

namespace Modules\Client\Cart\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class CartRequest extends FormRequest
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
            'code' => ['required', 'min:10'],
            'count' => ['required', 'integer'],
            'product_id' => ['required', 'exists:products,id'],
            'size' => ['required', 'string']
        ];
    }

    public function messages() {
        return [
            'required' => __('Client/Cart::Validation.required'),
            'integer' => __('Client/Cart::Validation.integer'),
            'exists' => __('Client/Cart::Validation.exists'),
            'string' => __('Client/Cart::Validation.string'),
            'min' => __('Client/Cart::Validation.min'),
        ];
    }

    public function attributes(){
        return [
            'code' =>__('Client/Cart::Validation.attributes.code'),
            'count' =>  __('Client/Cart::Validation.attributes.count'),
            'product_id' =>  __('Client/Cart::Validation.attributes.product_id'),
            'size' =>  __('Client/Cart::Validation.attributes.size'),
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
