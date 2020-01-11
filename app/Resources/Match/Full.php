<?php

namespace App\Resources\Match;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\Character\Full as CharacterResource;

class Full extends JsonResource
{
    public function toArray($request)
    {
        $return = [
            'id' => $this->resource->id,
            'strategy' => $this->resource->strategy,
            'prediction' => $this->resource->prediction,
            'tier' => $this->resource->tier,
            'mode' => $this->resource->mode,
            'odds' => $this->resource->odds,
            'time' => $this->resource->time,
            'date' => $this->resource->date->format('Y-m-d H:i:s'),
        ];

        if ($this->resource->relationLoaded('character_a')) {
            $return = array_merge([
                'character_a' => CharacterResource::make($this->resource->character_a)
            ], $return);
        }

        if ($this->resource->relationLoaded('character_b')) {
            $return = array_merge([
                'character_b' => CharacterResource::make($this->resource->character_b)
            ], $return);
        }

        if ($this->resource->relationLoaded('winner')) {
            $return = array_merge([
                'winner' => CharacterResource::make($this->resource->winner)
            ], $return);
        }

        if ($this->resource->relationLoaded('crowd_favourite')) {
            $return = array_merge([
                'crowd_favourite' => CharacterResource::make($this->resource->crowd_favourite)
            ], $return);
        }

        if ($this->resource->relationLoaded('illum_favourite')) {
            $return = array_merge([
                'illum_favourite' => CharacterResource::make($this->resource->illum_favourite)
            ], $return);
        }

        return $return;
    }
}