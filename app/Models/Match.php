<?php

namespace App\Models;

use App\Models\Character;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'character_a_id',
        'character_b_id',
        'character_winner_id',
        'character_crowd_favour_id',
        'character_illum_favour_id',
        'character_a_bet_return',
        'character_b_bet_return',
        'strategy',
        'prediction',
        'tier',
        'mode',
        'odds',
        'time',
        'date',
        'hash'
    ];

    protected $dates = ['date'];

    public function character_a()
    {
        return $this->belongsTo(Character::class, 'character_a_id', 'id');
    }

    public function character_b()
    {
        return $this->belongsTo(Character::class, 'character_b_id', 'id');
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