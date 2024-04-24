<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserSubscriptionOrderRequest extends FormRequest
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
            'plan_id' => 'required|integer',
            //'customer_id' => 'required|integer',
            //'address' => 'required|string',
            //'amount' => 'numeric',
            //'tax' => 'required|numeric',
            'discount' => 'numeric',
            //'total_amount' => 'required|numeric',
        ];
    }
}
