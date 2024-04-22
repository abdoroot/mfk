<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\BookingStatus;

class OrderHistoryResource extends JsonResource
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
            'id'                    => $this->id,
            'shipping_address'               => $this->shipping_address,
            'customer_id'           => $this->customer_id,
            'items'            => $this->FormattedItems,
            //'items'            => $this->service_id,
            //'provider_id'           => $this->provider_id, no provider in store
            'created_at'                  => $this->created_at,
            'price'                 => optional($this->service)->price,
            'type'                  => optional($this->service)->type,
            'discount'              => optional($this->service)->discount,
            'status'                => $this->status,
            'status_label'          => BookingStatus::bookingStatus($this->status),
            'description'           => $this->description,
            'customer_name'         => optional($this->customer)->display_name,
            'payment_id'            => $this->payment_id,
            'payment_status'        => optional($this->payment)->payment_status,
            'payment_method'        => optional($this->payment)->payment_type,
            'customer_name'         => optional($this->customer)->display_name,
            //'service_name'          => optional($this->service)->name,
            //'service_attchments'    => getAttachments(optional($this->service)->getMedia('service_attachment'),null),
            //'taxes'                 => json_decode($this->tax,true),
            'quantity'              => $this->quantity,
            'coupon_data'           => isset($this->couponAdded) ? $this->couponAdded : null,
            'total_amount'          => $this->total_amount,
            'amount'                => $this->amount,
            //'advance_paid_amount'  => $this->advance_paid_amount == null ? 0:(double) $this->advance_paid_amount,
            //'advance_payment_amount' => optional($this->service)->advance_payment_amount == null ? 0:(bool) optional($this->service)->advance_payment_amount,
        ];
    }
}
