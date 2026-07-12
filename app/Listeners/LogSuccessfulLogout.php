<?php

namespace App\Listeners;

use App\Models\AuditLog;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Request;

class LogSuccessfulLogout
{
    public function handle(Logout $event): void
    {
        $user = $event->user;
        if (!$user) return;

        AuditLog::create([
            'user_id'     => $user->id,
            'user_name'   => $user->first_name . ' ' . $user->last_name,
            'action'      => 'LOGOUT',
            'module'      => 'Auth',
            'description' => $user->first_name . ' ' . $user->last_name . ' logged out',
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::userAgent(),
        ]);
    }
}
