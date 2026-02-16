<?php

namespace App\Core;

use PDO;

abstract class Model
{
    protected $table;
    protected $primaryKey = 'id';
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        
        if (!$this->table) {
            // Infer table name from class name (e.g., User -> users)
            $className = (new \ReflectionClass($this))->getShortName();
            $this->table = strtolower($className) . 's';
        }
    }

    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function where($column, $value)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll();
    }
    
    public function firstWhere($column, $value)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1");
        $stmt->execute(['value' => $value]);
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute($data)) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function update($id, array $data)
    {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= "{$key} = :{$key}, ";
        }
        $fields = rtrim($fields, ', ');
        
        $sql = "UPDATE {$this->table} SET {$fields} WHERE {$this->primaryKey} = :id";
        
        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    // Query Builder Methods (Simplified)
    public static function query() {
        return new static();
    }
}
