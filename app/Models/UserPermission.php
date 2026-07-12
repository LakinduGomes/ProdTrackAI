<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $table = 'tbl_user_permissions';

    protected $fillable = [
        'id','user','module','add_permission','edit_permission','delete_permission','approve_permission'
    ];
}
