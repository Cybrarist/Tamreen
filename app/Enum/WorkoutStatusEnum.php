<?php

namespace App\Enum;

enum WorkoutStatusEnum : string
{
    case Pending = "pending";

    case PartiallyCompleted="partial";

    case Completed = "completed";

}
