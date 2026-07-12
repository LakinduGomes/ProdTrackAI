<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLog extends Model
{
    protected $table = 'tbl_audit_logs';

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'module',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    public static function log($action, $module, $description = null, $oldValues = [], $newValues = [])
    {
        $user = Auth::user();

        static::create([
            'user_id'     => $user?->id,
            'user_name'   => $user ? $user->first_name . ' ' . $user->last_name : 'System',
            'action'      => $action,
            'module'      => $module,
            'description' => $description,
            'old_values'  => $oldValues ? json_encode($oldValues) : null,
            'new_values'  => $newValues ? json_encode($newValues) : null,
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::userAgent(),
        ]);
    }
}