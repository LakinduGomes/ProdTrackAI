<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'assigned_user_id',
        'status',
        'priority',
        'deadline'
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function prediction()
    {
        return $this->hasOne(Prediction::class, 'task_id');
    }
}