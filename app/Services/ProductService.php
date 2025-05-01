<?php 

namespace App\Services;

use App\Models\Product;
use Core\Database;
use Exception;

class ProductService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Product();
    }

    public function createProduct($data, $files)
    {
        $db = Database::getInstance();
        $db->beginTransaction();

        try {
            // Validasi
            if (empty($data['name']) || empty($data['price'])) {
                throw new Exception("Nama dan harga wajib diisi.");
            }

            // Simpan product
            $productId = $this->model->create($data);

            // Upload multiple files
            foreach ($files['images']['tmp_name'] as $i => $tmp) {
                if ($tmp === '') continue;

                $filename = time() . '_' . basename($files['images']['name'][$i]);
                $dest = __DIR__ . '/../../public/uploads/products/' . $filename;

                if (!move_uploaded_file($tmp, $dest)) {
                    throw new Exception("Gagal upload gambar.");
                }

                $this->model->addImage($productId, $filename);
            }

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
}
