<?php
namespace App\Models;

use Core\Model;
use PDO;

class Permission extends Model
{
    protected $table = 'permissions';

    public function all()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} order by menu asc");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
