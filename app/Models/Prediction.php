<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    protected $table = 'predictions';

    protected $fillable = [
        'task_id',
        'delay_probability',
        'predicted_outcome'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}