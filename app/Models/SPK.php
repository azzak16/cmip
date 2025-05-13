<?php
namespace App\Models;

use Core\Model;
use PDO;

class SPK extends Model
{
    protected $table = 'sales_orders';

    // public function __construct()
    // {
    //     $this->db = Database::getInstance();
    // }

    public function number($date)
    {
        $dates = explode('-', $date);

        $years = $dates[0];
        $year = substr($years, 2, 2);
    
        $months = (int) $dates[1];
        $month = numberToRoman($months);

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} 
                WHERE order_number LIKE 'SOL%' 
                and YEAR(order_date) = $years
                order by created_at desc limit 1");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $code = '';

        if (empty($data)) {
            $code = "SOL/1/$month/$year";
        } else {
            
            $parts = explode('/', $data[0]['order_number']);
            $angka = isset($parts[1]) ? (int) $parts[1] : null;
            $angka = $angka + 1;

            $code = "SOL/$angka/$month/$year";
        }

        return $code;
    }

    public function code($customer_id, $date)
    {
        $dates = explode('-', $date);

        $years = $dates[0];
        $year = substr($years, 2, 2);
    
        $months = $dates[1];

        $stmt = $this->db->prepare("SELECT * FROM customers 
                WHERE NO_ID = $customer_id");

        $stmt->execute();
        $data_cs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} 
                WHERE order_number LIKE 'SOL%' 
                and YEAR(order_date) = $years
                and MONTH(order_date) = $months
                order by created_at desc limit 1");
        $stmt->execute();
        $data_so = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $code = '';

        if (empty($data_so)) {
            $code = $data_cs[0]['CS_KODE']."-01{$months}{$year}";
        } else {
            
            $parts = explode('-', $data_so[0]['production_code']);
            $angka = isset($parts[1]) ? substr($parts[1], 0, 2) : null;
            $angka = $angka + 1;
            $angka = str_pad($angka, 2, '0', STR_PAD_LEFT);

            $code = $data_cs[0]['CS_KODE']."-{$angka}{$months}{$year}";
        }
        
        return $code;
    }

    public function spk()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE status = 'SPK' AND deleted_at IS NULL");
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
