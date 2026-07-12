<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserRolesController extends Controller
{
    public function index()
    {
        return view('business.admin.userroles');
    }
}
