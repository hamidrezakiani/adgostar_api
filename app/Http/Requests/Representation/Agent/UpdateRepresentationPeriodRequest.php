<?php

namespace App\Http\Requests\Representation\Agent;

use App\Models\RepresentationItemPeriod;
use App\Models\UserTicket;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\JsonResponse;

class UpdateRepresentationPeriodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
         return Gate::allows('representation-period',$this->route()->parameter('period'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userProfit' => 'required|numeric',
            'normalRepresentationProfit' => 'required|numeric',
            'seniorRepresentationProfit' => 'required|numeric'
        ];
    }

    public function attributes()
    {
        return [
            'userProfit' => 'ُسود کابر',
            'normalRepresentationProfit' => 'سود نمایندگی معمولی',
            'seniorRepresentationProfit' => 'سود نمایندگی ارشد'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute ضرروی است',
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
