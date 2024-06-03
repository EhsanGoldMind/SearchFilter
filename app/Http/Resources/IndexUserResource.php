<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class IndexUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {

        return [
            'id'=>$this['id'],
            'name'=>$this['name'],
            'ssn'=>$this['ssn'],
            'phone_number'=>$this['phone_number'],
            'email'=>$this['email'],
        ];
    }
}
