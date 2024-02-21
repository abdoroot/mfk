<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $image = getSingleMedia($this,'store_item_attachment', null);
        $file_extention = config('constant.IMAGE_EXTENTIONS');
        $extention = in_array(strtolower(imageExtention($image)),$file_extention);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'provider_id' => $this->provider_id,
            'price' => $this->price,
            'price_format' => getPriceFormat($this->price),
            'discount' => $this->discount,
            'status' => $this->status,
            'description' => $this->description,
            'is_featured' => $this->is_featured,
            'provider_name' => optional($this->providers)->display_name,
            'provider_image' => optional($this->providers)->login_type != null ? optional($this->providers)->social_image : getSingleMedia(optional($this->providers), 'profile_image', null),
            'category_name' => optional($this->category)->name,
            'subcategory_name' => optional($this->subcategory)->name,
            'attachments' => getAttachments($this->getMedia('store_item_attachment')), // Updated from 'service_attachment'
            'attachments_array' => getAttachmentArray($this->getMedia('store_item_attachment'), null), // Updated from 'service_attachment'
            'attachment_extension' => $extention, // Updated variable name
            'deleted_at' => $this->deleted_at,
            // Other fields as required
        ];
    }
}
