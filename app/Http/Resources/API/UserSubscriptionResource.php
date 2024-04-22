<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'provider_id'       => $this->provider_id,
            'title'             => $this->title,
            'status'            => $this->status,
            'category_id'       => $this->category_id,
            'subcategory_id'    => $this->subcategory_id,
            'amount'            => $this->amount,
            'plan_type'         => $this->plan_type,
            'description'       => $this->description,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at
        ];
    }
}
