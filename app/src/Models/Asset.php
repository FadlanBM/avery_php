<?php

namespace App\Models;

use App\Core\Model;

class Asset extends Model
{
    protected $table = 'assets';
    public function findAssetById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch();
    }
}
