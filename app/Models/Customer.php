<?php
namespace App\Models;

use Core\Model;
use PDO;

class Customer extends Model
{
    protected $table = 'customers';

    // public function __construct()
    // {
    //     $this->db = Database::getInstance();
    // }

    public function all()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allActiveByTenant($tenant_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE tenant_id = :tenant_id AND deleted_at IS NULL");
        $stmt->execute(['tenant_id' => $tenant_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function addImage($productId, $filename)
    {
        $stmt = $this->db->prepare("INSERT INTO product_images (product_id, file_path) VALUES (?, ?)");
        $stmt->execute([$productId, $filename]);
    }
}
