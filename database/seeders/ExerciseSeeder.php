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
        $exerciseUnit = array_flip(ExerciseUnitEnum::toArray());



        Exercise::factory()
            ->forEachSequence(
            [
                "name" => "Arnold Press",
                "description" => "",
                "unit" => array_rand($exerciseUnit),

            ],
            [
                "name" => "Bicep Curl",
                "description" => "Don't use momentum. Make sure the movement is coming from the bottom half of your arm not your shoulder moving the weight.",
                "unit" => array_rand($exerciseUnit),
            ],
            [
                "name" => "Bicycle Crunch",
                "description" => "The lower the \"straight\" leg is to the ground the more challenging this exercise is. ",
                "unit" => array_rand($exerciseUnit),
            ],
            [
                "name" => "Bounds",
                "description" => "Do laps across the room of these.",
                "unit" => array_rand($exerciseUnit),
            ],
            [
                "name" => "Box Jumps",
                "description" => "Don't be afraid, you can jump higher than you think. Just try it once.",
                "unit" => array_rand($exerciseUnit),
            ],
            [
                "name" => "Box Toe Touch",
                "description" => "",
                "unit" => array_rand($exerciseUnit),
            ],
            [
                "name" => "Broad Jump",
                "description" => "You can do these for speed, or for distance. Speed = Cardio, Distance/Height = Plyo",
                "unit" => array_rand($exerciseUnit),
            ],
            [
                "name" => "Bulgarian Split Squat",
                "description" => "Use Single 30LB Dumbbell or an Olympic Bar",
            ],
            [
                "name" => "Burpee",
                "description" => "Option with half Bosu, Pushup Optional. Make sure you don't round your back",
            ],
            [
                "name" => "Burpee Broad Jump",
                "description" => "Do laps of these across the room if you have the space.",
            ],
            [
                "name" => "Butt Kickers",
                "description" => "Do it like you mean it, or this exercise is a waste of time. ",
            ],
            [
                "name" => "Calf Raise",
                "description" => "Play around with foot placement, some gyms also have machines for this",
            ],
            [
                "name" => "Chest Press",
                "description" => "You can do this lying on the ground, or on a bench top",
            ],
            [
                "name" => "Close to Wide Grip Burnout",
                "description" => "",
            ],
            [
                "name" => "Compass Jump",
                "description" => "These can also be done with both feet on the ground.",
            ],
            [
                "name" => "Crab Crawl",
                "description" => "",
            ],
            [
                "name" => "Curtsey Lunges",
                "description" => "",
            ],
            [
                "name" => "Deficit Squat",
                "description" => "",
            ],
            [
                "name" => "Donkey Kick",
                "description" => "",
            ],
            [
                "name" => "Fire Hydrant",
                "description" => "",
            ],
            [
                "name" => "Flutter Kick",
                "description" => "Her neck looks like its undergoing some serious strain. Feel free to leave yours on the ground.",
            ],
            [
                "name" => "Frogger",
                "description" => "",
            ],
            [
                "name" => "Glute Bridge",
                "description" => "If using weights, place in hip crease",
            ],
            [
                "name" => "Glute Bridge March",
                "description" => "",
            ],
            [
                "name" => "Goblet Squat",
                "description" => "",
            ],
            [
                "name" => "Halo",
                "description" => "",
            ],
            [
                "name" => "Heart Pump",
                "description" => "",
            ],
            [
                "name" => "High Knees",
                "description" => "My coach always says, your high knees tells a lot about your dedication. Do yours like the guy in the gif. Get your knees up or don't bother!",
            ],
            [
                "name" => "Jump Lunges",
                "description" => "",
            ],
            [
                "name" => "Jump Rope",
                "description" => "",
            ],
            [
                "name" => "Jumping Jack Push Press",
                "description" => "",
            ],
            [
                "name" => "Jumping Jacks",
                "description" => "Go faster than the gif lady. I chose her because she has good form, your hand should always touch at the top",
            ],
            [
                "name" => "Kettlebell Swing",
                "description" => "When I do these I usually keep my hand close to my body and let my hips \"push\" the movement. If you'd like to experiment, you can use a dumbbell instead",
            ],
            [
                "name" => "Knee Drive",
                "description" => "",
            ],
            [
                "name" => "Lateral Band Walk",
                "description" => "",
            ],
            [
                "name" => "Leg Pull Apart",
                "description" => "",
            ],
            [
                "name" => "Leg Raise",
                "description" => "Hold onto something heavy",
            ],
            [
                "name" => "Literally Just Jumping",
                "description" => "No good gifs for this, keep core tight, minimize time on the ground and jump up and down."
            ],
            [
                "name" => "Lying Leg Raises",
                "description" => ""
            ],
            [
                "name" => "Military Plank",
                "description" => ""
            ],
            [
                "name" => "Monkey Jump",
                "description" => ""
            ],
            [
                "name" => "Mountain Climbers",
                "description" => ""
            ],
            [
                "name" => "Plank",
                "description" => ""
            ],
            [
                "name" => "Plank Jack",
                "description" => ""
            ],
            [
                "name" => "Plank Row",
                "description" => ""
            ],
            [
                "name" => "Pushup",
                "description" => "Can be done from knees, or legs. Arms parallel to your body like the dude in the gif."
            ],
            [
                "name" => "Pushup Walk",
                "description" => ""
            ],
            [
                "name" => "Reverse Crunches",
                "description" => ""
            ],
            [
                "name" => "Row",
                "description" => "Bar + 15LB"
            ],
            [
                "name" => "Russian Twist",
                "description" => ""
            ],
            [
                "name" => "Seal Jacks",
                "description" => "Clap your hands and dance around while you do these. Makes life more fun."
            ],
            [
                "name" => "Shoulder Press",
                "description" => "Bar + 5LB"
            ],
            [
                "name" => "Side Arm / Lateral Raise",
                "description" => ""
            ],
            [
                "name" => "Side Lunge",
                "description" => ""
            ],
            [
                "name" => "Side Plank",
                "description" => ""
            ],
            [
                "name" => "Side Plank Dips",
                "description" => ""
            ],
            [
                "name" => "Side Plank with Leg Lift",
                "description" => "",
            ],
            [
                "name" => "Single Arm Clean and Press ",
                "description" => "Currently using 25LB",
            ],
            [
                "name" => "Single Leg Hip Bridge",
                "description" => "You're wasting your time on this if you're not actually thinking about squeezing your glutes with each movement. You really need to be focused to do this."
            ],
            [
                "name" => "Single Leg Squat",
                "description" => "",
            ],
            [
                "name" => "Situp and Throw",
                "description" => ""
            ],
            [
                "name" => "Skaters",
                "description" => "Lady in the gif isn't giving it 100% make sure to touch the ground between reps"
            ],
            [
                "name" => "Skipping",
                "description" => "",
            ],
            [
                "name" => "Skull Crusher",
                "description" => "",
            ],
            [
                "name" => "Spiderman Pushup",
                "description" => ""
            ],
            [
                "name" => "Squat",
                "description" => "Bar + 45LB",
            ],
            [
                "name" => "Squat Jump",
                "description" => "You can do these for height (plyo) or speed (cardio) and to switch them up sometimes do them with your arms clasped at the front so it's a leg-only exercise"
            ],
            [
                "name" => "Squat Jumps 180",
                "description" => "Turn body 180 while doing squat jump"
            ],
            [
                "name" => "Squat to Lateral Leg Lift",
                "description" => "",
            ],
            [
                "name" => "Standing Glute Kickbaks",
                "description" => "",
            ],
            [
                "name" => "Standing Leg Lift",
                "description" => "",
            ],
            [
                "name" => "Standing Oblique Crunch",
                "description" => "20LB Weight Minimum"
            ],
            [
                "name" => "Star Jump",
                "description" => ""
            ],
            [
                "name" => "Step Up Lunges",
                "description" => ""
            ],
            [
                "name" => "Step-Back Lunge",
                "description" => ""
            ],
            [
                "name" => "Straightup Situp",
                "description" => ""
            ],
            [
                "name" => "Sumo Squat",
                "description" => "Bar + 35LB. You want your legs to be just wide enough that your knees still track over your toes"
            ],
            [
                "name" => "Superman",
                "description" => "",
            ],
            [
                "name" => "Touchdown",
                "description" => "",
            ],
            [
                "name" => "Tricep Dip",
                "description" => "Find a chair or platform you can lean on."
            ],
            [
                "name" => "Tricep Kick-Back",
                "description" => ""
            ],
            [
                "name" => "Tricep Overhead Press",
                "description" => "",
            ],
            [
                "name" => "Tuck Jump",
                "description" => ""
            ],
            [
                "name" => "Twisted Mountain Climbers",
                "description" => "",
            ],
            [
                "name" => "Wall Ball",
                "description" => "Toss the Medicine Ball in the air, or against a solid wall (concrete or brick) if available."
            ],
            [
                "name" => "Weighted Jumping Jacks",
                "description" => "",
            ],
            [
                "name" => "Weighted Punches",
                "description" => "",
            ],
            [
                "name" => "Deadbug",
                "description" => "Really good if you have lower back pain and want to do an ab workout"
            ],
        )
            ->create();
    }
}
