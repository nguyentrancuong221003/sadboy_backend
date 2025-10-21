<?php

namespace Modules\Client\Comment\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class CommentRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => ['required', 'string', 'min:10'],
            'content' => ['required', 'string'],
            'imgs'   => ['nullable', 'array'],
            'imgs.*' => ['file', 'image', 'max:2048'],
            'star' => ['required', 'integer'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ];
    }

    public function messages() {
        return [
            'required' => __('Client/Comment::Validation.required'),
            'min' => __('Client/Comment::Validation.min'),
            'integer' => __('Client/Comment::Validation.integer'),
            'file' => __('Client/Comment::Validation.file'),
            'image' => __('Client/Comment::Validation.image'),
            'string' => __('Client/Comment::Validation.string'),
            'max' => __('Client/Comment::Validation.max'),
            'exists' => __('Client/Comment::Validation.exists'),
            'array' => __('Client/Comment::Validation.array'),
        ];
    }

    public function attributes(){
        return [
            'code' =>  __('Client/Comment::Validation.attributes.code'),
            'content' =>  __('Client/Comment::Validation.attributes.content'),
            'imgs' =>  __('Client/Comment::Validation.attributes.imgs'),
            'star' =>  __('Client/Comment::Validation.attributes.star'),
            'product_id' =>  __('Client/Comment::Validation.attributes.product_id'),
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
