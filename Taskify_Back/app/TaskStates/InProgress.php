<?php

namespace App\TaskStates;

class InProgress extends TaskState
{
    public static function displayName(): string
    {
        return 'In Progress';
    }
}
