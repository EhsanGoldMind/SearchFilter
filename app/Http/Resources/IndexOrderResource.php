<?php

namespace App\Http\Resources;

use App\Enums\OrderStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;


class IndexOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {

        return [
            'id'=>$this['id']  ,
            'subject'=>$this['subject'],
            'description'=>$this['description'],
            'amount'=>$this['amount'],
            'status'=>OrderStatusEnum::getName($this['status']),
            'user' => new IndexUserResource($this->whenLoaded('user')),
        ];
    }
}
