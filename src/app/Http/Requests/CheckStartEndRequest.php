<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class CheckStartEndRequest extends FormRequest
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
            'start' => ['required', 'integer', 'min:0'],
            'end' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages() {
        return [
            'required' => ':attribute không được phép để trống',
            'integer' => 'Bắt buộc phải là một số nguyên',
            'min' => 'Giá trị phải lớn hơn hoặc bằng 1'
        ];
    }

    public function attributes(){
        return [
            'start' =>  'Tham số start',
            'end' => 'Tham số end',

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
