<?php

namespace App\TaskStates;

class Cancelled extends TaskState
{
    public static function displayName(): string
    {
        return 'Cancelled';
    }
}
