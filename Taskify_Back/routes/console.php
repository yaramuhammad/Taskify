<?php

use App\Console\Commands\TaskDueReminder;
use Illuminate\Support\Facades\Schedule;

Schedule::command(TaskDueReminder::class)->everyMinute();
