<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class productResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return[
            'id'=>$this->id,
            'product_name'=>$this->name,
            'price'=>[
                'before_price'=>$this->price_compare,
                'after_price'=>$this->price
            ],
            'image'=>$this->image_url,
            'category'=>[
                'id'=>$this->category->id,
                'name'=>$this->category->name
            ],
            'store'=>[
                'id'=>$this->store->id,
                'name'=>$this->store->name
            ]
        ];
    }
}
