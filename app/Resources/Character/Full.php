<?php

namespace App\Resources\Character;

use Illuminate\Http\Resources\Json\JsonResource;

class Full extends JsonResource
{
    public function toArray($request)
    {
        $return = [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'wins' => $this->resource->wins,
            'losses' => $this->resource->losses,
            'total' => $this->resource->wins + $this->resource->losses
        ];

        if ($this->resource->relationLoaded('matches')) {
            $return = array_merge([
                'matches' => $this->collection($this->resource->matches)
            ], $return);
        }

        return $return;
    }
}