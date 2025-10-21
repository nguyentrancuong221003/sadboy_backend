<?php

namespace Modules\Admin\Cash_book\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class AddBillRequest extends FormRequest
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
            'type' => ['required', 'string'],
            'reason' => ['required', 'string'],
            'money' => ['required', 'numeric'],
            'imgs.*' => ['required', 'file', 'image', 'max:2048'], // từng file
            'receiver' => ['required', 'string'],
            'name' => ['required', 'string']
        ];
    }

    public function messages() {
        return [
            'required' => __('Admin/Cash_book::Validation.required'),
            'min' => __('Admin/Cash_book::Validation.min'),
            'numeric' => __('Admin/Cash_book::Validation.numeric'),
            'file' => __('Admin/Cash_book::Validation.file'),
            'image' => __('Admin/Cash_book::Validation.image'),
            'max' => __('Admin/Cash_book::Validation.max'),
            'string' => __('Admin/Cash_book::Validation.string'),
        ];
    }

    public function attributes(){
        return [
            'code' =>  __('Admin/Cash_book::Validation.attributes.code'),
            'type' =>  __('Admin/Cash_book::Validation.attributes.type'),
            'reason' =>  __('Admin/Cash_book::Validation.attributes.reason'),
            'money' =>  __('Admin/Cash_book::Validation.attributes.money'),
            'imgs' =>  __('Admin/Cash_book::Validation.attributes.imgs'),
            'receiver' =>  __('Admin/Cash_book::Validation.attributes.receiver'),
            'name' =>  __('Admin/Cash_book::Validation.attributes.name'),
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
