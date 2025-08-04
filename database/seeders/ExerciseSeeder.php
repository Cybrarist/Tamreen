<?php

namespace Database\Seeders;

use App\Enum\ExerciseUnitEnum;
use App\Models\Exercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if (Exercise::count() > 0) {
            return;
        }

        Exercise::factory()
            ->forEachSequence(
            [
                "name" => "Arnold Press",
                "unit" => ExerciseUnitEnum::Reps->value,

            ],
            [
                "name" => "Bicep Curl",
                "description" => "Don't use momentum. Make sure the movement is coming from the bottom half of your arm not your shoulder moving the weight.",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Bicycle Crunch",
                "description" => "The lower the \"straight\" leg is to the ground the more challenging this exercise is. ",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Bounds",
                "description" => "Do laps across the room of these.",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Box Jumps",
                "description" => "Don't be afraid, you can jump higher than you think. Just try it once.",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Box Toe Touch",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Broad Jump",
                "description" => "You can do these for speed, or for distance. Speed = Cardio, Distance/Height = Plyo",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Bulgarian Split Squat",
                "description" => "Use Single 30LB Dumbbell or an Olympic Bar",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Burpee",
                "description" => "Option with half Bosu, Pushup Optional. Make sure you don't round your back",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Burpee Broad Jump",
                "description" => "Do laps of these across the room if you have the space.",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Butt Kickers",
                "description" => "Do it like you mean it, or this exercise is a waste of time. ",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Calf Raise",
                "description" => "Play around with foot placement, some gyms also have machines for this",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Chest Press",
                "description" => "You can do this lying on the ground, or on a bench top",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Close to Wide Grip Burnout",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Compass Jump",
                "description" => "These can also be done with both feet on the ground.",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Crab Crawl",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Curtsey Lunges",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Deficit Squat",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Donkey Kick",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Fire Hydrant",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Flutter Kick",
                "description" => "Her neck looks like its undergoing some serious strain. Feel free to leave yours on the ground.",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Frogger",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Glute Bridge",
                "description" => "If using weights, place in hip crease",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Glute Bridge March",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Goblet Squat",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Halo",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Heart Pump",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "High Knees",
                "description" => "My coach always says, your high knees tells a lot about your dedication. Do yours like the guy in the gif. Get your knees up or don't bother!",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Jump Lunges",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Jump Rope",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Jumping Jack Push Press",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Jumping Jacks",
                "description" => "Go faster than the gif lady. I chose her because she has good form, your hand should always touch at the top",
                "unit" => ExerciseUnitEnum::Seconds->value,
            ],
            [
                "name" => "Kettlebell Swing",
                "description" => "When I do these I usually keep my hand close to my body and let my hips \"push\" the movement. If you'd like to experiment, you can use a dumbbell instead",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Knee Drive",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Lateral Band Walk",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Leg Pull Apart",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Leg Raise",
                "description" => "Hold onto something heavy",
                "unit" => ExerciseUnitEnum::Seconds->value,
            ],
            [
                "name" => "Lying Leg Raises",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Military Plank",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Monkey Jump",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Mountain Climbers",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Plank",
                "description" => "",
                "unit" => ExerciseUnitEnum::Seconds->value,
            ],
            [
                "name" => "Plank Jack",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Plank Row",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Pushup",
                "description" => "Can be done from knees, or legs. Arms parallel to your body like the dude in the gif.",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Pushup Walk",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Reverse Crunches",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Row",
                "description" => "Bar + 15LB",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Russian Twist",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Seal Jacks",
                "description" => "Clap your hands and dance around while you do these. Makes life more fun.",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Shoulder Press",
                "description" => "Bar + 5LB",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Side Arm / Lateral Raise",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Side Lunge",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Side Plank",
                "description" => "",
                "unit" => ExerciseUnitEnum::Seconds->value,
            ],
            [
                "name" => "Side Plank Dips",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Side Plank with Leg Lift",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Single Arm Clean and Press ",
                "description" => "Currently using 25LB",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Single Leg Hip Bridge",
                "description" => "You're wasting your time on this if you're not actually thinking about squeezing your glutes with each movement. You really need to be focused to do this.",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Single Leg Squat",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Situp and Throw",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Skaters",
                "description" => "Lady in the gif isn't giving it 100% make sure to touch the ground between reps",
                "unit" => ExerciseUnitEnum::Reps->value,

            ],
            [
                "name" => "Skipping",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Skull Crusher",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Spiderman Pushup",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,

            ],
            [
                "name" => "Squat",
                "description" => "Bar + 45LB",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Squat Jump",
                "description" => "You can do these for height (plyo) or speed (cardio) and to switch them up sometimes do them with your arms clasped at the front so it's a leg-only exercise",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Squat Jumps 180",
                "description" => "Turn body 180 while doing squat jump",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Squat to Lateral Leg Lift",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Standing Glute Kickbaks",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Standing Leg Lift",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Standing Oblique Crunch",
                "description" => "20LB Weight Minimum",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Star Jump",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Step Up Lunges",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Step-Back Lunge",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Straightup Situp",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Sumo Squat",
                "description" => "Bar + 35LB. You want your legs to be just wide enough that your knees still track over your toes",
                "unit" => ExerciseUnitEnum::Reps->value,

            ],
            [
                "name" => "Superman",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Touchdown",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Tricep Dip",
                "description" => "Find a chair or platform you can lean on.",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Tricep Kick-Back",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Tricep Overhead Press",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Tuck Jump",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Twisted Mountain Climbers",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Wall Ball",
                "description" => "Toss the Medicine Ball in the air, or against a solid wall (concrete or brick) if available.",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Weighted Jumping Jacks",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Weighted Punches",
                "description" => "",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
            [
                "name" => "Deadbug",
                "description" => "Really good if you have lower back pain and want to do an ab workout",
                "unit" => ExerciseUnitEnum::Reps->value,
            ],
        )
            ->create();
    }
}
