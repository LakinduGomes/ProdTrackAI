<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportedTask extends Model
{
    protected $table = 'imported_tasks';

    protected $fillable = [
        'session_id',
        'task_name',
        'assigned_to',
        'priority',
        'complexity',
        'estimated_hours',
        'actual_hours',
        'story_points',
        'assignee_experience',
        'work_mode',
        'tasks_assigned_count',
        'start_date',
        'due_date',
        'completed_date',
        'status',
        'delay_probability',
        'delay_risk_bucket',
        'predicted_label',
        'converted_task_id',
        'raw_data',
    ];

    protected $casts = [
        'raw_data' => 'array',
        'start_date' => 'date',
        'due_date' => 'date',
        'completed_date' => 'date',
        'delay_probability' => 'float',
        'estimated_hours' => 'float',
        'actual_hours' => 'float',
        'story_points' => 'float',
        'tasks_assigned_count' => 'integer',
    ];

    public function session()
    {
        return $this->belongsTo(ImportedTaskSession::class, 'session_id');
    }

    public function convertedTask()
    {
        return $this->belongsTo(Task::class, 'converted_task_id');
    }
}