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

    public function getAllWithRoles()
    {
        $stmt = $this->db->prepare("
            SELECT u.*, r.name as role_name 
            FROM {$this->table} u 
            LEFT JOIN role r ON u.role_id = r.id
        ");
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($attributes) => new static($attributes), $results);
    }
}
