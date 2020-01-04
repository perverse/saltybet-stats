<?php

namespace App\Repositories;

use App\Models\Character;

class CharacterRepository extends Repository
{
    public function getModel()
    {
        return Character::class;
    }
}