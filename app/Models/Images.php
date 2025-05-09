<?php
namespace App\Models;

use Core\Model;
use PDO;

class Images extends Model
{
    // protected $table = 'sales_order_images';

    // public function __construct()
    // {
    //     $this->db = Database::getInstance();
    // }

    public function all()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE deleted_at IS NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allActiveByTenant($tenant_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE tenant_id = :tenant_id AND deleted_at IS NULL");
        $stmt->execute(['tenant_id' => $tenant_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function addImage($table, $column, $id, $filename)
    {
        $stmt = $this->db->prepare("INSERT INTO $table ($column, file_name) VALUES (?, ?)");
        $stmt->execute([$id, $filename]);
    }
}
