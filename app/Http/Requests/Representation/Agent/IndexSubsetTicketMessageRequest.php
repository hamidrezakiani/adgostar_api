<?php

namespace App\Http\Requests\Representation\Agent;

use App\Models\UserTicket;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class IndexSubsetTicketMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(UserTicket $userTicket)
    {
        return Gate::allows('representation-ticket',$this->route()->parameter('subsetTicket'));
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
