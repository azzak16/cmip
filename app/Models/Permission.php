<?php
namespace App\Models;

use Core\Model;
use PDO;

class Permission extends Model
{
    protected $table = 'Permissions';

    public function all()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
