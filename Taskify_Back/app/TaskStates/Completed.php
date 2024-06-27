<?php

namespace App\TaskStates;

class Completed extends TaskState
{
    public static function displayName(): string
    {
        return 'Completed';
    }
}
