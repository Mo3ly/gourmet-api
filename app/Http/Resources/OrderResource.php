<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderProductResourceCollection;

class OrderResource extends JsonResource
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
            'name' => $this->username,
            'table' => $this->table_number,
            'status' => $this->status,
            'date' =>  date('Y-m-d h:i', strtotime($this->created_at)),
            'products' => new OrderProductResourceCollection($this->getProducts),
        ];
    }
}
