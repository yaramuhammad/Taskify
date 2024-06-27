<?php

namespace App\TaskStates;

use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class TaskState extends State
{
    /**
     * @throws InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(ToDo::class)
            ->allowTransition(ToDo::class, InProgress::class)
            ->allowTransition(InProgress::class, Completed::class)
            ->allowTransition(Completed::class, Reopened::class)
            ->allowTransition(InProgress::class, Cancelled::class)
            ->allowTransition(ToDo::class, Cancelled::class)
            ->allowTransition(Completed::class, Reopened::class)
            ->allowTransition(Cancelled::class, Reopened::class)
            ->allowTransition(Reopened::class, Completed::class);

    }
}
