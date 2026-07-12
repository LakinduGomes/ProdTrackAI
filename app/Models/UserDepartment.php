<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    protected $table = 'tbl_master_user_department';

    protected $fillable = ['name', 'status'];
}