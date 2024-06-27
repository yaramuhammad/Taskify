<?php

namespace App\TaskStates;

class Reopened extends TaskState
{
    public static function displayName(): string
    {
        return 'Reopened';
    }
}
