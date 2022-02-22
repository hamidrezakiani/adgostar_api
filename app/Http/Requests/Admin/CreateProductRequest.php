<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class CreateProductRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:2|max:100',
            // 'dateType' => Rule::in(['SINGLE', 'MULTIPLE']),
            'viewable' => Rule::in(['YES','NO']),
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'نام محصول',
            'viewable' => 'وضعیت انتشار',
            'dateType' => 'نوع تاریخ',
            'category_id' => 'دسته بندی',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute ضرروی است',
            'in' => ':attribute انتخاب شده صحیح نمی باشد',
            'exists' => ':attribute انتخاب شده صحیح نمی باشد',
            'max' => [
                'string' => ':attribute نباید بیشتر از  :max کاراکتر باشد.',
            ],

            'min' => [
                'string' => ' :attribute نباید کم تر از :min کاراکتر باشد.',
            ],

        ];
    }

    protected function failedValidation(ValidationValidator $validator)
    {
        $response = new JsonResponse([
                'data' => [],
                'errors' =>  $validator->errors(),
             ], 422);

    throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
