<?php

namespace App\TaskStates;

class ToDo extends TaskState
{
    public static function displayName(): string
    {
        return 'To Do';
    }
}
