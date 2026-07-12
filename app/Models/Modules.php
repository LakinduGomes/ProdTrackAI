<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $table = 'tbl_master_user_modules';
    protected $fillable = ['name', 'status', 'section'];
}