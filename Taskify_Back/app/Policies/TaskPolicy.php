<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Log;

class TaskPolicy
{

    public function create(User $user, Workspace $workspace): bool
    {
        Log::debug('hello');
        return $user->id == $workspace->owner->id || $user->memberAtWorkspaces()->where('workspace_id', $workspace->id)->exists();
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->createdBy;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->createdBy;
    }


}
