<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkspaceRequest;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    public function index()
    {
        return auth()->user()->ownedWorkspaces->concat(auth()->user()->memberAtWorkspaces);
    }

    public function show(Workspace $workspace)
    {
        return $workspace->tasks;
    }

    public function showMembers(Workspace $workspace)
    {
        return collect([$workspace->owner])->merge($workspace->users);
    }

    public function create(CreateWorkspaceRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        return Workspace::create($data);
    }

    public function addMember(Workspace $workspace, Request $request)
    {
        if ($workspace->type == 'Personal') {
            return response('You cannot add members to your personal workspace');
        }
        $users = User::all();
        $user = $users->where('email', $request->get('email'))->first();
        $user->memberAtWorkspaces()->attach([$workspace->id]);

        return response()->noContent();
    }

    public function destroy(Workspace $workspace)
    {
        $workspace->delete();

        return response()->noContent();
    }

    public function deleteMember(Workspace $workspace, User $user)
    {
        $user->memberAtWorkspaces()->detach([$workspace->id]);

        return response()->noContent();
    }

    public function UpdateTitle(Workspace $workspace, Request $request)
    {
        $workspace->title = $request->get('title');
        $workspace->save();

        return $workspace;
    }
}
