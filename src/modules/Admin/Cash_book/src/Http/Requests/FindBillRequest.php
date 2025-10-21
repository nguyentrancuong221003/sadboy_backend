<?php

namespace Modules\Admin\Cash_book\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use function PHPUnit\Framework\isEmpty;
class FindBillRequest extends FormRequest
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
            'page' => ['required', 'min:0', 'integer'],
            'date' => ['required', 'date'],
            'code' => ['nullable', 'string'],
            'count' => ['required', 'integer']
        ];
    }

    public function messages() {
        return [
            'required' => ':attribute không được phép để trống',
            'min' => ':attribute phải lơn hơn :min',
            'integer' => ':attribute phải là một số',
            'date' => ':attribute phải là một ngày',
            'string' => ':attribute phải là một chuỗi'
        ];
    }

    public function attributes(){
        return [
            'code' => 'Mã phiếu thu',
            'date' => 'Ngày',
            'page' => 'Trang',
            'count' => 'Số'
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
