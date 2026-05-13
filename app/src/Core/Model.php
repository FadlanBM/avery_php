<?php

namespace App\Core;

use PDO;

abstract class Model implements \ArrayAccess
{
    protected $table;
    protected $primaryKey = 'id';
    protected $db;
    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->db = Database::getInstance()->getConnection();
        $this->attributes = $attributes;
        
        if (!$this->table) {
            $className = (new \ReflectionClass($this))->getShortName();
            // Simple pluralization: User -> users, Role -> roles, RoleModel -> roles
            $this->table = strtolower(str_replace('Model', '', $className)) . 's';
        }
    }

    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($attributes) => new static($attributes), $results);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->execute(['id' => $id]);
        $attributes = $stmt->fetch(PDO::FETCH_ASSOC);
        return $attributes ? new static($attributes) : null;
    }

    public function where($column, $value)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value");
        $stmt->execute(['value' => $value]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($attributes) => new static($attributes), $results);
    }
    
    public function firstWhere($column, $value)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1");
        $stmt->execute(['value' => $value]);
        $attributes = $stmt->fetch(PDO::FETCH_ASSOC);
        return $attributes ? new static($attributes) : null;
    }

    public function create(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $driver = $this->db->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        if ($driver === 'pgsql') {
            $sql .= " RETURNING {$this->primaryKey}";
        }
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute($data)) {
            $id = $driver === 'pgsql' ? $stmt->fetchColumn() : $this->db->lastInsertId();
            return $this->find($id ?: ($data[$this->primaryKey] ?? null));
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
        
        if ($stmt->execute($data)) {
            $this->attributes = array_merge($this->attributes, $data);
            return true;
        }
        return false;
    }

    public function delete($id = null)
    {
        $id = $id ?: ($this->attributes[$this->primaryKey] ?? null);
        if (!$id) return false;

        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Relationships
    public function belongsTo($related, $foreignKey, $ownerKey = 'id')
    {
        $instance = new $related();
        $value = $this->attributes[$foreignKey] ?? null;
        return $value ? $instance->find($value) : null;
    }

    public function hasMany($related, $foreignKey, $localKey = 'id')
    {
        $instance = new $related();
        $value = $this->attributes[$localKey] ?? null;
        return $value ? $instance->where($foreignKey, $value) : [];
    }

    // ArrayAccess & Magic Methods
    public function offsetExists($offset): bool { return isset($this->attributes[$offset]); }
    public function offsetGet($offset): mixed { return $this->attributes[$offset] ?? null; }
    public function offsetSet($offset, $value): void { $this->attributes[$offset] = $value; }
    public function offsetUnset($offset): void { unset($this->attributes[$offset]); }

    public function __get($key) { return $this->attributes[$key] ?? null; }
    public function __set($key, $value) { $this->attributes[$key] = $value; }
    public function __isset($key) { return isset($this->attributes[$key]); }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function updateOrCreate(array $attributes, array $values)
    {
        $query = "SELECT * FROM {$this->table} WHERE ";
        $params = [];
        $conditions = [];
        foreach ($attributes as $key => $value) {
            $conditions[] = "{$key} = :attr_{$key}";
            $params["attr_{$key}"] = $value;
        }
        $query .= implode(' AND ', $conditions) . " LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $this->update($result[$this->primaryKey], $values);
            return $this->find($result[$this->primaryKey]);
        } else {
            return $this->create(array_merge($attributes, $values));
        }
    }

    public static function query() { return new static(); }
}
