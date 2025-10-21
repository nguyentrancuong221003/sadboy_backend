<?php

namespace Modules\Admin\Voucher\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class VoucherRequest extends FormRequest
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
        $id = $this->route('id');
        $isUpdate = in_array($this->method(), ['PUT', 'PATCH']);

        return [
            'code' => $isUpdate
                ? ['nullable', 'min:10', Rule::unique('vouchers', 'code')->ignore($id)]
                : ['required', 'min:10', Rule::unique('vouchers', 'code')]
            ,
            'name' => $isUpdate
                ? ['nullable', 'min:10', 'string']
                : ['required', 'min:10', 'string']
            ,
            'img' => ['nullable', 'file', 'image', 'max:2048'],
            'type' => $isUpdate
                ? ['nullable', 'string']
                : ['required', 'string']
            ,
            'percent' => ['nullable', 'numeric'],
            'max_money' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/'],
            'money_discount' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/'],
            'total_user' => $isUpdate
                ? ['nullable', 'integer']
                : ['required', 'integer']
            ,
            'count_use' => ['nullable'],
            'per_use' => $isUpdate
                ? ['nullable', 'integer']
                : ['required', 'integer']
            ,
            'order_price_smallest' => $isUpdate
                ? ['nullable', 'regex:/^\d+(\.\d{1,2})?$/']
                : ['required', 'regex:/^\d+(\.\d{1,2})?$/']
            ,
            'user_apply' => $isUpdate
                ? ['nullable', 'string']
                : ['required', 'string']
            ,
            'category_id' => $isUpdate
                ? ['nullable', 'integer', 'exists:categories,id']
                : ['required', 'integer', 'exists:categories,id']
            ,
            'date_effect' => $isUpdate
                ? ['nullable', 'date']
                : ['required', 'date']
            ,
            'date_end' => $isUpdate
                ? ['nullable', 'date']
                : ['required', 'date']
            ,
            'status' => $isUpdate
                ? ['nullable', 'string']
                : ['required', 'string']
            ,
            'add_user_monoply' => ['nullable', 'exists:users,code'],
            'delete_user_monoply'   => ['nullable', 'array'],
            'delete_user_monoply.*' => ['exists:user_voucher,user_id'],
        ];

    }
    public function messages() {
        return [
            'required' => __('Admin/Voucher::Validation.required'),
            'string' => __('Admin/Voucher::Validation.string'),
            'min' => __('Admin/Voucher::Validation.min'),
            'file' => __('Admin/Voucher::Validation.file'),
            'image' => __('Admin/Voucher::Validation.image'),
            'max' => __('Admin/Voucher::Validation.max'),
            'exists' => __('Admin/Voucher::Validation.exists'),
            'numeric' => __('Admin/Voucher::Validation.numeric'),
            'integer' => __('Admin/Voucher::Validation.integer'),
            'json' => __('Admin/Voucher::Validation.json'),
            'array' => __('Admin/Voucher::Validation.array'),
            'add_user_monoply' => __('Admin/Voucher::Validation.add_user_monoply'),
            //'delete_user_monoply' => __('Admin/Voucher::Validation.delete_user_monoply'),
            'delete_user_monoply.*.exists' => __('Admin/Voucher::Validation.exists'),
        ];
    }

    public function attributes(){
        return [
            'code' =>  __('Admin/Voucher::Validation.attributes.code'),
            'name' => __('Admin/Voucher::Validation.attributes.name'),
            'img' => __('Admin/Voucher::Validation.attributes.img'),
            'type' => __('Admin/Voucher::Validation.attributes.type'),
            'percent' => __('Admin/Voucher::Validation.attributes.percent'),
            'max_money' => __('Admin/Voucher::Validation.attributes.max_money'),
            'money_discount' => __('Admin/Voucher::Validation.attributes.money_discount'),
            'total_user' => __('Admin/Voucher::Validation.attributes.total_user'),
            'count_use' => __('Admin/Voucher::Validation.attributes.count_use'),
            'per_use' => __('Admin/Voucher::Validation.attributes.per_use'),
            'order_price_smallest' => __('Admin/Voucher::Validation.attributes.order_price_smallest'),
            'user_apply' => __('Admin/Voucher::Validation.attributes.user_apply'),
            'category_id' => __('Admin/Voucher::Validation.attributes.category_id'),
            'date_effect' => __('Admin/Voucher::Validation.attributes.date_effect'),
            'date_end' => __('Admin/Voucher::Validation.attributes.date_end'),
            'status' => __('Admin/Voucher::Validation.attributes.status'),
            'add_user_monoply' => __('Admin/Voucher::Validation.attributes.add_user_monoply'),
            'delete_user_monoply' => __('Admin/Voucher::Validation.attributes.delete_user_monoply'),
            'delete_user_monoply.*' => __('Admin/Voucher::Validation.attributes.delete_user_monoply'),

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
