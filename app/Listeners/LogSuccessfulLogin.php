<?php

namespace App\Listeners;

use App\Models\AuditLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        $user = $event->user;
        if (!$user) return;

        AuditLog::create([
            'user_id'     => $user->id,
            'user_name'   => $user->first_name . ' ' . $user->last_name,
            'action'      => 'LOGIN',
            'module'      => 'Auth',
            'description' => $user->first_name . ' ' . $user->last_name . ' logged in',
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::userAgent(),
        ]);
    }
}
