<?php

namespace App\Http\Requests\Representation;

use App\Models\UserTicket;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\JsonResponse;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(UserTicket $userTicket)
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
            'phone' => 'required',
            'password' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'phone' => 'شماره تلفن',
            'password' => 'کلمه عبور',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute اجباری است',
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
