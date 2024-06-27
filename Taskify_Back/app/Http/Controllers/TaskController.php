<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use App\Models\User;
use App\Models\Workspace;
use App\Notifications\AssignmentNotification;
use App\Notifications\TaskUpdateNotification;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Workspace $workspace, CreateTaskRequest $request)
    {
        $data = $request->validated();
        $data['createdBy'] = $request->user()->id;
        $data['workspace_id'] = $workspace->id;
        if ($workspace->type == 'Personal') {
            $data['assignedTo'] = $request->user()->id;
        }
        $task = Task::create($data);

        return $task;
    }

    public function Update(Workspace $workspace, Task $task, Request $request)
    {
        $task->update($request->all());
        $task->assignedTo()->first()->notify(new TaskUpdateNotification($task));

        return $task;
    }

    public function Destroy(Workspace $workspace, Task $task, Request $request)
    {
        $task->delete();

        return response()->noContent();
    }

    public function assign(Workspace $workspace, Task $task, User $user)
    {
        if (! $user->memberAtWorkspaces()->where('workspace_id', $workspace->id)->exists()) {
            return response("This User is not member in {$workspace->title}");
        }
        $task->assignedTo = $user->id;
        $task->save();
        $user->notify(new AssignmentNotification($task));

        return $task;
    }

    public function updateState(Task $task, $state)
    {
        $taskStateClass = 'App\\TaskStates\\'.ucfirst($state);

        if (! class_exists($taskStateClass)) {
            abort(404, 'State not found');
        }
        $task->state->transitionTo($taskStateClass);
        $task->save();

        $task->createdBy()->first()->notify(new TaskUpdateNotification($task));
        $task->assignedTo()->first()->notify(new TaskUpdateNotification($task));

        return $task;
    }
}
