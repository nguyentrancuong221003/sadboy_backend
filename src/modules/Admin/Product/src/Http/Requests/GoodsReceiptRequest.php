<?php

namespace Modules\Admin\Product\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class GoodsReceiptRequest extends FormRequest
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
        $id = $this->route('id'); // Nếu route là /product/{id}
        $isUpdate = in_array($this->method(), ['PUT', 'PATCH']);
        return [
            'code' => $isUpdate
                ? ['nullable', 'min:10', Rule::unique('products', 'code')->ignore($id)]
                : ['required', 'min:10', Rule::unique('products', 'code')]
            ,
            'count' => $isUpdate
                ? ['nullable', 'integer']
                : ['required', 'integer']
            ,
            'date_receive' => $isUpdate
                ? ['nullable', 'date']
                : ['required', 'date']
            ,
            'discount' => ['nullable'],
            'subtotal' => $isUpdate
                ? ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/']
                : ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/']
            ,
            'total' => $isUpdate
                ? ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/']
                : ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/']
            ,
            'note' => ['nullable', 'string'],
            'note_cancel' => ['nullable', 'string'],
            'other_cost' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'products' => $isUpdate
                ? ['nullable', 'array']
                : ['required', 'array']
            ,
            'status' => ['nullable', 'string'],
            'stock_id' => $isUpdate
                ? ['nullable', 'integer', 'exists:stocks,id']
                : ['required', 'integer', 'exists:stocks,id']
            ,
            'provide_id' => $isUpdate
                ? ['nullable', 'integer', 'exists:product_provide_supply,provide_id']
                : ['required', 'integer', 'exists:product_provide_supply,provide_id']
            ,
        ];
    }

    public function messages() {
        return [
            'required' => __('Admin/Product::Validation.required'),
            'email' => __('Admin/Product::Validation.email'),
            'min' => __('Admin/Product::Validation.min'),
            'date' => __('Admin/Product::Validation.date'),
            'integer' => __('Admin/Product::Validation.integer'),
            'numeric' => __('Admin/Product::Validation.numeric'),
            'max' => __('Admin/Product::Validation.max'),
            'exists' => __('Admin/Product::Validation.exists'),
            'array' => __('Admin/Product::Validation.array'),
            'decimal' =>  __('Admin/Product::Validation.decimal'),
        ];
    }

    public function attributes(){
        return [
            'code' =>  __('Admin/Product::Validation.attributes.code'),
            'count' =>  __('Admin/Product::Validation.attributes.count'),
            'date_receive' =>  __('Admin/Product::Validation.attributes.date_receive'),
            'discount' => __('Admin/Product::Validation.attributes.discount'),
            'subtotal' => __('Admin/Product::Validation.attributes.subtotal'),
            'total' => __('Admin/Product::Validation.attributes.total'),
            'note' => __('Admin/Product::Validation.attributes.note'),
            'note_cancel' => __('Admin/Product::Validation.attributes.note_cancel'),
            'other_cost' => __('Admin/Product::Validation.attributes.other_cost'),
            'products' => __('Admin/Product::Validation.attributes.products'),
            'status' => __('Admin/Product::Validation.attributes.status'),
            'stock_id' => __('Admin/Product::Validation.attributes.stock_id'),
            'provide_id' => __('Admin/Product::Validation.attributes.provide_id'),
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
