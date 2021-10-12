<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuProductResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = null;
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'desc_ar' => $this->desc_ar,
            'desc_en' => $this->desc_en,
            'isNew' => $this->isNew,
            'isSpecial' => $this->isSpecial,
            'resturant' => $this->getCategory->getResturant->name_en,
            'price' => $this->price,
            'image' => $this->getMedia->url ?? null,
        ];
    }
}
