<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MenuProductResource;

class OrderProductResource extends JsonResource
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
            "id"=> $this->id,
            "data"=> new MenuProductResource($this->getProduct),
            "quantity"=> $this->quantity,
            "total_price"=> $this->quantity * $this->getProduct->price,
            "notes"=> $this->notes,
            "options"=> $this->options,
            "additions"=> $this->additions,
            "status"=> "not-ready",
        ];
    }
}
