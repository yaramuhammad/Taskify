<?php

use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkspaceController;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->name('password.store');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth:sanctum', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');

Route::post('/workspace/{workspace}/task', [TaskController::class, 'create'])
    ->middleware('auth:sanctum')
    ->can('create',[Task::class, 'workspace']);

Route::post('/workspace/{workspace}/task/{task}', [TaskController::class, 'update'])
    ->middleware('auth:sanctum')
    ->can('update', 'task');

Route::delete('/workspace/{workspace}/task/{task}', [TaskController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->can('delete', 'task');

Route::post('/workspace/{workspace}/task/{task}/assign/{user}', [TaskController::class, 'assign'])
    ->middleware('auth:sanctum')
    ->can('update', 'task');

Route::post('/workspace', [WorkspaceController::class, 'create'])
    ->middleware('auth:sanctum');

Route::put('/workspace/{workspace}', [WorkspaceController::class, 'UpdateTitle'])
    ->middleware('auth:sanctum')->can('delete', 'workspace');

Route::delete('/workspace/{workspace}', [WorkspaceController::class, 'destroy'])
    ->middleware('auth:sanctum')->can('delete', 'workspace');

Route::get('/workspace', [WorkspaceController::class, 'index'])->middleware('auth:sanctum');

Route::get('/workspace/{workspace}/tasks', [WorkspaceController::class, 'show'])->middleware('auth:sanctum')
    ->can('show', 'workspace');

Route::get('/workspace/{workspace}/members', [WorkspaceController::class, 'showMembers'])->middleware('auth:sanctum')
    ->can('show', 'workspace');

Route::patch('/workspace/{workspace}/add', [WorkspaceController::class, 'addMember'])
    ->middleware('auth:sanctum')->can('addMember', 'workspace');
Route::patch('/workspace/{workspace}/delete/{user}', [WorkspaceController::class, 'deleteMember'])
    ->middleware('auth:sanctum')->can('deleteMember', ['workspace', 'user']);

Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');

Route::post('/profile/updateEmail', [ProfileController::class, 'updateEmail'])->middleware('auth:sanctum');
Route::post('/profile/updateImage', [ProfileController::class, 'updateImage'])->middleware('auth:sanctum');
Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword'])->middleware('auth:sanctum');

Route::post('/task/{task}/{state}', [TaskController::class, 'updateState'])
    ->middleware('auth:sanctum')
    ->can('update', 'task');
