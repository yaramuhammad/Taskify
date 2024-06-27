<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskDueNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TaskDueReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:task-due-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasksDueSoon = Task::where('due_date', '<=', Carbon::now()->addDay())
            ->where('due_date', '>', Carbon::now())
            ->get();

        foreach ($tasksDueSoon as $task) {
            $user = $task->assignedTo()->first();
            $user->notify(new TaskDueNotification($task));
        }
    }
}
