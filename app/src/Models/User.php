<?php

namespace App\Models;

use App\Core\Model;
use App\Models\RoleModel;

class User extends Model
{
    protected $table = 'users';

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id', 'id');
    }
}
