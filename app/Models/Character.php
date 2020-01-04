<?php

namespace App\Models;

use App\Models\Character;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $table = 'characters';

    protected $fillable = [
        'name'
    ];

    protected $dates = ['date'];

    public function character_a()
    {
        return $this->belongsTo(Character::class, 'character_a_id', 'id');
    }

    public function character_b()
    {
        return $this->belongsTo(Character::class, 'character_b_d', 'id');
    }

    public function winner()
    {
        return $this->belongsTo(Character::class, 'character_winner_id', 'id');
    }

    public function crowd_favourite()
    {
        return $this->belongsTo(Character::class, 'character_crowd_favour_id', 'id');
    }

    public function illum_favourite()
    {
        return $this->belongsTo(Character::class, 'character_illum_favour_id', 'id');
    }
}