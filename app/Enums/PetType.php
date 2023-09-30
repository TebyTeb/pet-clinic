<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PetType: string implements HasLabel
{
    case Dog = 'dog';
    case Cat = 'cat';
    case Rat = 'rat';
    case Lizard = 'lizard';
    case Rabbit = 'rabbit';
    case Fish = 'fish';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Dog => 'Dog',
            self::Cat => 'Cat',
            self::Rat => 'Rat',
            self::Lizard => 'Lizard',
            self::Rabbit => 'Rabbit',
            self::Fish => 'Fish',
        };
    }
}
