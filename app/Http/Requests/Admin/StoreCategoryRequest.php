<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\JsonResponse;


class StoreCategoryRequest extends FormRequest
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
           'name' => 'required|min:2|max:100',
           'label' => 'required|min:2|max:100',
           'parent_id' => 'exists:categories,id',
           'showParent_id' => 'exists:categories,id'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام دسته',
            'label' => 'برچسب دسته'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute ضرروی است',
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
