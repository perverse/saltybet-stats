<?php

namespace App\Resources\Character;

use App\Resources\Match;
use Illuminate\Http\Resources\Json\JsonResource;

class Full extends JsonResource
{
    public function toArray($request)
    {
        $total = $this->resource->wins + $this->resource->losses;
        $winrate = $total ? round(((int) $this->resource->wins / (int) $total) * 100) : 0;

        $return = [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'wins' => $this->resource->wins,
            'losses' => $this->resource->losses,
            'total' => $total,
            'winrate' => $winrate,
            'rating' => round($winrate / 10) / 2
        ];

        if ($this->resource->relationLoaded('matches')) {
            $return = array_merge([
                'matches' => Match\Full::collection($this->resource->matches)
            ], $return);
        }

        return $return;
    }
}