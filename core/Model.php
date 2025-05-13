<?php

namespace Core;

use Core\Database;
use Exception;
use PDO;
use PDOException;

abstract class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function find($id, $type = 'id', $soft_delete = true)
    {
        if ($soft_delete) {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE $type = :$type AND deleted_at IS NULL");
        } else {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE $type = :$type");
        }
        $stmt->execute(["$type" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertId(array $data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $stmt = $this->db->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");

        if (!$stmt->execute($data)) {
            $error = $stmt->errorInfo(); 
            throw new Exception("Gagal insert");
        }

        return $this->db->lastInsertId();
    }

    public function insert(array $data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $stmt = $this->db->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");

        return $stmt->execute($data);
    }

    public function update(array $data, $id,  $type = 'id')
    {
        $fields = '';
        foreach ($data as $key => $val) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ', ');
        $data["$type"] = $id;
        $stmt = $this->db->prepare("UPDATE {$this->table} SET $fields WHERE $type = :$type");
        return $stmt->execute($data);
    }

    public function delete($id, $type = 'id')
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE $type = :$type");
        return $stmt->execute(["$type" => $id]);
    }

    public function softDelete($id)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET deleted_at = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE deleted_at IS NULL");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count()
    {
        $stmt = $this->db->query("SELECT count(*) FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function raw($query, $params = [])
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

}
