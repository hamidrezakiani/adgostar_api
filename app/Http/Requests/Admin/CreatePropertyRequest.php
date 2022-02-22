<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\JsonResponse;

class CreatePropertyRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'property_type_id' => 'required|exists:property_types,id',
            'label' => 'required|min:2|max:100',
            'size' => 'required',
            'placeholder' => 'min:2|max:100',
            'tooltip' => 'min:2|max:100',
            'required' => Rule::in(['YES', 'NO']),
        ];
    }
    public function attributes()
    {
        return [
            'label' => 'متن برچسب',
            'size' => 'حداکثر سایز',
            'property_type_id' => 'نوع خصوصیات',
            'product_id' => 'محصول',
            'placeholder' => 'متن راهنما',
            'tooltip' => 'متن تولتیپ',
            'required' => 'ضرورت',
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
