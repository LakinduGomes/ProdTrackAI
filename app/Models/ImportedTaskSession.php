<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportedTaskSession extends Model
{
    protected $table = 'imported_task_sessions';

    protected $fillable = [
        'user_id',
        'original_filename',
        'total_rows',
        'processed_rows',
        'failed_rows',
        'status',
        'column_mapping',
        'error_log',
    ];

    protected $casts = [
        'column_mapping' => 'array',
    ];

    public function tasks()
    {
        return $this->hasMany(ImportedTask::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}