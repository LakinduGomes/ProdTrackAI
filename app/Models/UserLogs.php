<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogs extends Model
{
    use HasFactory;

    protected $table = 'tbl_user_logs';

    protected $fillable = ['id','user','module','action','operation','created_at','updated_at'];

}