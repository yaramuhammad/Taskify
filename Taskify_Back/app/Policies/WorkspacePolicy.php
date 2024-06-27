<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;

class WorkspacePolicy
{
    /**
     * Create a new policy instance.
     */
    public function addMember(User $user, Workspace $workspace)
    {
        return $user->id == $workspace->owner->id;
    }

    public function deleteMember(User $user, Workspace $workspace, User $user2): bool
    {
        return $user->id == $workspace->owner->id || $user->id == $user2->id;
    }

    public function delete(User $user, Workspace $workspace): bool
    {
        return $user->id == $workspace->owner->id;
    }

    public function show(User $user, Workspace $workspace)
    {
        return $user->id == $workspace->owner->id || $user->memberAtWorkspaces()->where('workspace_id', $workspace->id)->exists();
    }
}
