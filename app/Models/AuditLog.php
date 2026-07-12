<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLog extends Model
{
    protected $table = 'tbl_audit_logs';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'user_name', 'action', 'module',
        'description', 'old_values', 'new_values',
        'ip_address', 'user_agent', 'created_at',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    // ── Static helper to log anything from anywhere ───────────────────────────
    public static function log(string $action, string $module, string $description, array $oldValues = [], array $newValues = [])
    {
        $user = Auth::user();

        static::create([
            'user_id'     => $user?->id,
            'user_name'   => $user ? $user->first_name . ' ' . $user->last_name : 'System',
            'action'      => $action,
            'module'      => $module,
            'description' => $description,
            'old_values'  => !empty($oldValues) ? $oldValues : null,
            'new_values'  => !empty($newValues) ? $newValues : null,
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::userAgent(),
            'created_at'  => now(),
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}