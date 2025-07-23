<?php

namespace Database\Seeders;

use App\Models\BodyPart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BodyPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $body_parts = [
            'Back',
            'Biceps',
            'Triceps',
            'Forearms',
            'Quads',
            'Glutes',
            'Hamstrings',
            'Calves',
            'Chest',
            'Legs',
            'Arms',
            'Shoulders',
            'Abs',
            'Hips',
            'Neck',
            'Waist',
            'Fingers',
        ];

        foreach ($body_parts as $body_part) {
            BodyPart::updateOrCreate(['name' => $body_part]);
        }


    }
}
