<?php

namespace Modules\Admin\Product\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class ProductRequest extends FormRequest
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
            'name' => $isUpdate
                ? ['nullable', 'min:5', 'string']
                : ['required', 'min:5', 'string']
            ,
            'imgs'   => ['nullable', 'array'], // mảng ảnh
            'imgs.*' => ['file', 'image', 'max:2048'], // từng file
            'provide_id' => $isUpdate
                ? ['nullable', 'integer', 'exists:provides,id']
                : ['required', 'integer', 'exists:provides,id']
            ,
            'category_id' => $isUpdate
                ? ['nullable', 'integer', 'exists:categories,id']
                : ['required', 'integer', 'exists:categories,id']
            ,
            'provide_id' => $isUpdate
                ? ['nullable', 'integer', 'exists:provides,id']
                : ['required', 'integer', 'exists:provides,id']
            ,
            'place' => $isUpdate
                ? ['nullable', 'string']
                : ['required', 'string']
            ,
            'star' => ['nullable', 'numeric'],
            'gift' => $isUpdate
                ? ['nullable', 'string']
                : ['required', 'string']
            ,
            'import_price' => $isUpdate
                ? ['nullable', 'json']
                : ['required', 'json']
            ,
            'original_price' => $isUpdate
                ? ['nullable']
                : ['required']
            ,
            'sale_price' => ['nullable', 'json'],
            'sort_description' => ['nullable', 'string'],
            'long_description' => ['nullable', 'string'],
            'count_comment' => ['nullable', 'integer'],
            'QR' => ['nullable'],
            'proportion_discount' => ['nullable', 'integer'],
            'date_start_sale' => ['nullable', 'date'],
            'date_end_sale' => ['nullable', 'date'],
            'count_stock'=> $isUpdate
                ? ['nullable', 'integer']
                : ['required', 'integer']
            ,
            'count_sale' => ['nullable', 'integer'],
            'status' => ['nullable'],
            'unit' => ['nullable']
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
            'file' => __('Admin/Product::Validation.file'),
            'image' => __('Admin/Product::Validation.image'),
            'max' => __('Admin/Product::Validation.max'),
            'exists' => __('Admin/Product::Validation.exists'),
            'array' => __('Admin/Product::Validation.array'),
            'json' => __('Admin/Product::Validation.json'),
        ];
    }

    public function attributes(){
        return [
            'code' =>  __('Admin/Product::Validation.attributes.code'),
            'name' => __('Admin/Product::Validation.attributes.name'),
            'imgs' => __('Admin/Product::Validation.attributes.imgs'),
            'category_id' => __('Admin/Product::Validation.attributes.category_id'),
            'place' => __('Admin/Product::Validation.attributes.place'),
            'star' => __('Admin/Product::Validation.attributes.star'),
            'gift' => __('Admin/Product::Validation.attributes.gift'),
            'import_price' => __('Admin/Product::Validation.attributes.import_price'),
            'original_price' => __('Admin/Product::Validation.attributes.original_price'),
            'sale_price' => __('Admin/Product::Validation.attributes.sale_price'),
            'sort_description' => __('Admin/Product::Validation.attributes.sort_description'),
            'long_description' => __('Admin/Product::Validation.attributes.long_description'),
            'count_comment' => __('Admin/Product::Validation.attributes.count_comment'),
            'OR' => __('Admin/Product::Validation.attributes.OR'),
            'proportion_discount' => __('Admin/Product::Validation.attributes.proportion_discount'),
            'date_start_sale' => __('Admin/Product::Validation.attributes.date_start_sale'),
            'date_end_sale' => __('Admin/Product::Validation.attributes.date_end_sale'),
            'count_stock' => __('Admin/Product::Validation.attributes.count_stock'),
            'count_sale' => __('Admin/Product::Validation.attributes.count_sale'),
            'status' => __('Admin/Product::Validation.attributes.status'),
            'unit' => __('Admin/Product::Validation.attributes.unit'),
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
