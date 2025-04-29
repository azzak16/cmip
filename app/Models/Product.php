<?php
namespace App\Models;

use Core\Model;
use PDO;

class Product extends Model
{
    protected $table = 'products';

    // public function __construct()
    // {
    //     $this->db = Database::getInstance();
    // }

    public function allActiveByTenant($tenant_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE tenant_id = :tenant_id AND deleted_at IS NULL");
        $stmt->execute(['tenant_id' => $tenant_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function softDelete($id)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET deleted_at = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, price, description) VALUES (?, ?, ?)");
        $stmt->execute([$data['name'], $data['price'], $data['description']]);
        return $this->db->lastInsertId();
    }

    public function addImage($productId, $filename)
    {
        $stmt = $this->db->prepare("INSERT INTO product_images (product_id, file_path) VALUES (?, ?)");
        $stmt->execute([$productId, $filename]);
    }
}
