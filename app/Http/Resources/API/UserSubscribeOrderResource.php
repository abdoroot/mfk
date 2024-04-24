<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\UserSubscriptionPlan;
use App\Models\Payment;

class UserSubscribeOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $plan = UserSubscriptionPlan::find($this->plan_id);
        //subscription_id == subscription order id
        $payment = Payment::where('subscription_id',$this->id)->first() ?? null;
        
        return [
            'id'                => $this->id,
            'plan_id'           => $this->plan_id,
            'title'             => $plan->title,
            'amount'            => $this->amount,
            'discount'            => $this->discount,
            'txn_id'            => optional($payment)->txn_id,
            'status'            => $this->status,
            'start_at'          => $this->start_at,
            'end_at'            => $this->end_at,
            'description'       => $plan->description,
            'plan_type'         => $this->plan_type,
        ];
    }
}
