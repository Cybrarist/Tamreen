<?php

namespace App\Enum;

enum ExerciseUnitEnum : string
{
    case Seconds = 'seconds';
    case Reps = 'reps';


    public static function toArray(): array
    {
        return [
            self::Seconds->value ,
            self::Reps->value ,
        ];
    }
}
