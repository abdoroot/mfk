<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\StoreItem;
class CartItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        $item = StoreItem::find($this->item_id);
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'guest_id' => $this->guest_id ?? "",
            'user_id' => $this->user_id ?? "",
            'name' => $item->name,
            'description' => $item->description,
            'price' => $item->price,
            'price_format' => getPriceFormat($item->price),
            'discount' => $item->discount,
            'attachments' => getAttachments($item->getMedia('store_item_attachment')),
        ];
    }
}
