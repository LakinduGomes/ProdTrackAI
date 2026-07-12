<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RemindersController extends Controller
{
    public function index()
    {
        return view('business.notification.reminders');
    }
}
