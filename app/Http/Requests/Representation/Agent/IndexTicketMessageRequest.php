<?php

namespace App\Http\Requests\Representation\Agent;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class IndexTicketMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('representation-ticket',$this->route()->parameter('ticket'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
