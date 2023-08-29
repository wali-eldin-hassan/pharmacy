<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles_user extends Model
{
    // PrimaryKey
    protected $table = 'roles_user';
    protected $primaryKey = 'user_id';
}
