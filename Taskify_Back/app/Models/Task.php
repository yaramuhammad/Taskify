<?php

namespace App\Models;

use App\TaskStates\TaskState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

class Task extends Model
{
    use HasFactory, HasStates;

    protected $guarded = [];

    protected $casts = [
        'state' => TaskState::class,
        'due_date' => 'datetime',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assignedTo');
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
