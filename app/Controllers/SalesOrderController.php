<?php 
namespace App\Controllers;

use App\Models\Images;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use Core\Controller;
use Core\Validator;
use Core\Auth;
use Core\Database;
use Core\Env;
use Core\Model;
use Exception;
use PDO;

class SalesOrderController extends Controller
{
    private $sales_order;
    private $data;

    public function __construct()
    {
        $this->sales_order = new SalesOrder();
        $this->data = [
            'title' => 'Sales Order',
        ];
    }

    public function index()
    {
        $this->view('sales-order/index', $this->data, 'layouts/main');
    }

    public function ajaxList()
    {
        header('Content-Type: application/json');
        echo json_encode($this->sales_order->all());
    }

    public function data()
    {
        $sales_orders = $this->sales_order->all();
        echo json_encode(['data' => $sales_orders]);
    }

    public function create()
    {
        $this->view('sales-order/create', $this->data, 'layouts/main');
    }

    public function store()
    {
        
        $db = Database::getInstance();
        $db->beginTransaction();

        $date = date('Y-m-d', strtotime($_POST['order_date']));

        $orde_number = $this->sales_order->number($date);
        $production_code = $this->sales_order->code($_POST['customer_id'], $date);

        try {

            $so_id = $this->sales_order->insert([
                'customer_id' => $_POST['customer_id'],
                'karat' => $_POST['karat_id'],
                'production_code' => $_POST['production_code']?: $production_code,
                'order_number' => $_POST['order_number']?: $orde_number,
                'order_date' => $date,
                'payment_terms' => $_POST['payment_terms'],
                'delivery_plan' => $_POST['delivery_plan'],
                'manager_production' => $_POST['manager_production'],
                'ppic' => $_POST['ppic'],
                'head_sales' => $_POST['head_sales'],
                'order_recipient' => $_POST['order_recipient'],
                'status' => $_POST['status'],
            ]);

            foreach ($_POST['product_desc'] as $key => $value) {
                $model_item = new SalesOrderItem();
                $model_item->insert([
                    'sales_order_id' => $so_id,
                    'product_desc' => $_POST['product_desc'][$key],
                    'ukuran_pcs' => $_POST['ukuran_pcs'][$key],
                    'panjang_pcs' => $_POST['panjang_pcs'][$key],
                    'gram_pcs' => $_POST['gram_pcs'][$key],
                    'batu_pcs' => $_POST['batu_pcs'][$key],
                    'tok_pcs' => $_POST['tok_pcs'][$key],
                    'color' => $_POST['color'][$key],
                    'karat' => $_POST['karat_id'],
                    'pcs' => $_POST['pcs'][$key],
                    'pairs' => $_POST['pairs'][$key],
                    'gram' => $_POST['gram'][$key],
                    'notes' => $_POST['note'][$key],
                ]);

                if (!$model_item) {
                    throw new Exception("Gagal menyimpan item ke-$key.");
                }
            }

            // Proses upload gambar
            $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB
            $uploadedFiles = [];
            $errors = [];
            
            if (isset($_FILES['images']) && $_FILES['images']['error'][0] !== UPLOAD_ERR_NO_FILE) {
                $files = $_FILES['images'];
                $fileCount = count($files['name']);
                $uploadDir = ROOT_PATH . 'public/images/so/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                for ($i = 0; $i < $fileCount; $i++) {

                    $ext = pathinfo($files['name'][$i],PATHINFO_EXTENSION);

                    $fileName = uniqid() . '.' . $ext;
                    $filePath = $uploadDir . $fileName;
                    $fileType = $files['type'][$i];
                    $fileSize = $files['size'][$i];
                    $fileError = $files['error'][$i];

                    // Validasi
                    if (!in_array($fileType, $allowedTypes)) {
                        $errors[] = "File {$files['name'][$i]}: Tipe file tidak diizinkan.";
                    } elseif ($fileSize > $maxSize) {
                        $errors[] = "File {$files['name'][$i]}: Ukuran file terlalu besar.";
                    } elseif ($fileError !== UPLOAD_ERR_OK) {
                        $errors[] = "File {$files['name'][$i]}: Gagal mengunggah.";
                    } else {
                        if (move_uploaded_file($files['tmp_name'][$i], $filePath)) {
                            // Simpan ke database
                            $upload_image = new Images;
                            $upload_image->addImage('sales_order_images', 'sales_order_id', $so_id, $fileName);
                            
                            $uploadedFiles[] = $fileName;
                        } else {
                            $errors[] = "File {$files['name'][$i]}: Gagal menyimpan file.";
                        }
                    }
                }
            }

            if (!empty($errors)) {
                $respon = implode('<br>', $errors);
                print_r($respon);
                throw new Exception($respon);
            }

            $db->commit();
            echo json_encode([
                'status' => true, 
                'message' => 'Sales Order berhasil disimpan.',
                'redirect' => Env::get('BASE_URL') . '/sales-order'
            ], JSON_UNESCAPED_SLASHES);

        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $result = $this->sales_order->raw(
            "SELECT sales_orders.*, customers.CS_NAMA, customers.CS_KODE
                FROM sales_orders
                left join customers on sales_orders.customer_id = customers.NO_ID
                WHERE sales_orders.id = $id"
        );
        $this->data['sales_orders'] = $result->fetchAll(PDO::FETCH_ASSOC);

        $result = $this->sales_order->raw(
            "SELECT *
                FROM sales_order_items
                WHERE sales_order_id = $id"
        );
        $this->data['sales_order_items'] = $result->fetchAll(PDO::FETCH_ASSOC);

        $result = $this->sales_order->raw(
            "SELECT *
                FROM sales_order_images
                WHERE sales_order_id = $id"
        );
        $this->data['sales_order_images'] = $result->fetchAll(PDO::FETCH_ASSOC);

        $this->view('sales-order/edit', $this->data, 'layouts/main');
    }

    public function print($id)
    {
        $this->data['sales_order'] = $this->sales_order->find($id);

        $this->view('sales-order/print', $this->data, 'layouts/main');
    }
    

    public function update($id)
    {

        $db = Database::getInstance();
        $db->beginTransaction();
        
        $date = date('Y-m-d', strtotime($_POST['order_date']));
        
        $orde_number = $this->sales_order->number($date);
        $production_code = $this->sales_order->code($_POST['customer_id'], $date);

        $deletedItems = json_decode($_POST['deleted_items'] ?? '[]', true);
        $deletedImages = json_decode($_POST['deleted_images'] ?? '[]', true);

        try {
            
            $this->sales_order->update([
                'customer_id' => $_POST['customer_id'],
                'karat' => $_POST['karat_id'],
                'production_code' => $_POST['production_code']?:$production_code,
                'order_number' => $_POST['order_number']?:$orde_number,
                'order_date' => $date,
                'payment_terms' => $_POST['payment_terms'],
                'delivery_plan' => $_POST['delivery_plan'],
                'manager_production' => $_POST['manager_production'],
                'ppic' => $_POST['ppic'],
                'head_sales' => $_POST['head_sales'],
                'order_recipient' => $_POST['order_recipient'],
                'status' => $_POST['status'],
            ], $id);

            // deleted items
            if (!empty($deletedItems)) {
                $this->sales_order->raw("DELETE FROM sales_order_items WHERE id IN (" . implode(',', $deletedItems) . ") AND sales_order_id = $id");                
            }

            foreach ($_POST['product_desc'] as $key => $value) {

                if (isset($_POST['item_id'][$key])) {
                    $model_item = new SalesOrderItem();
                    $model_item->update([
                        'sales_order_id' => $id,    
                        'product_desc' => $_POST['product_desc'][$key],
                        'ukuran_pcs' => $_POST['ukuran_pcs'][$key],
                        'panjang_pcs' => $_POST['panjang_pcs'][$key],
                        'gram_pcs' => $_POST['gram_pcs'][$key],
                        'batu_pcs' => $_POST['batu_pcs'][$key],
                        'tok_pcs' => $_POST['tok_pcs'][$key],
                        'color' => $_POST['color'][$key],
                        'karat' => $_POST['karat_id'],
                        'pcs' => $_POST['pcs'][$key],
                        'pairs' => $_POST['pairs'][$key],
                        'gram' => $_POST['gram'][$key],
                        'notes' => $_POST['note'][$key],
                    ], $_POST['item_id'][$key]);
                }else{
                    $model_item = new SalesOrderItem();
                    $model_item->insert([
                        'sales_order_id' => $id,
                        'product_desc' => $_POST['product_desc'][$key],
                        'ukuran_pcs' => $_POST['ukuran_pcs'][$key],
                        'panjang_pcs' => $_POST['panjang_pcs'][$key],
                        'gram_pcs' => $_POST['gram_pcs'][$key],
                        'batu_pcs' => $_POST['batu_pcs'][$key],
                        'tok_pcs' => $_POST['tok_pcs'][$key],
                        'color' => $_POST['color'][$key],
                        'karat' => $_POST['karat_id'],
                        'pcs' => $_POST['pcs'][$key],
                        'pairs' => $_POST['pairs'][$key],
                        'gram' => $_POST['gram'][$key],
                        'notes' => $_POST['note'][$key],
                    ]);
                }


                if (!$model_item) {
                    throw new Exception("Gagal menyimpan item ke-$key.");
                }
            }

            if (!empty($deletedImages)) {
                $stmt = $this->sales_order->raw("SELECT file_name FROM sales_order_images WHERE id IN (" . implode(',', $deletedImages) . ") AND sales_order_id = $id");
                $filesToDelete = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                $stmt = $this->sales_order->raw("DELETE FROM sales_order_images WHERE id IN (" . implode(',', $deletedImages) . ") AND sales_order_id = $id");

                $uploadDir = realpath(ROOT_PATH . 'public/images/so/') . '/';
                foreach ($filesToDelete as $file) {
                    $filePath = $uploadDir . $file['file_name'];
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            // Proses upload gambar
            $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB
            $uploadedFiles = [];
            $errors = [];
            
            if (isset($_FILES['images']) && $_FILES['images']['error'][0] !== UPLOAD_ERR_NO_FILE) {

                $files = $_FILES['images'];
                $fileCount = count($files['name']);
                $uploadDir = ROOT_PATH . 'public/images/so/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                for ($i = 0; $i < $fileCount; $i++) {

                    $stmt = $this->sales_order->raw("SELECT file_name FROM sales_order_images WHERE file_name = '" . $files['name'][$i] . "'  AND sales_order_id = $id");
                    $check = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                    if (!$check) {
                        $ext = pathinfo($files['name'][$i],PATHINFO_EXTENSION);
    
                        $fileName = uniqid() . '.' . $ext;
                        $filePath = $uploadDir . $fileName;
                        $fileType = $files['type'][$i];
                        $fileSize = $files['size'][$i];
                        $fileError = $files['error'][$i];
    
                        // Validasi
                        if (!in_array($fileType, $allowedTypes)) {
                            $errors[] = "File {$files['name'][$i]}: Tipe file tidak diizinkan.";
                        } elseif ($fileSize > $maxSize) {
                            $errors[] = "File {$files['name'][$i]}: Ukuran file terlalu besar.";
                        } elseif ($fileError !== UPLOAD_ERR_OK) {
                            $errors[] = "File {$files['name'][$i]}: Gagal mengunggah.";
                        } else {
                            if (move_uploaded_file($files['tmp_name'][$i], $filePath)) {
                                // Simpan ke database
                                $upload_image = new Images;
                                $upload_image->addImage('sales_order_images', 'sales_order_id', $id, $fileName);
                                
                                $uploadedFiles[] = $fileName;
                            } else {
                                $errors[] = "File {$files['name'][$i]}: Gagal menyimpan file.";
                            }
                        }
                    }

                }
            }

            if (!empty($errors)) {
                $respon = implode('<br>', $errors);
                print_r($respon);
                throw new Exception($respon);
            }

            $db->commit();
            echo json_encode([
                'status' => true, 
                'message' => 'Sales Order berhasil dirubah.',
                'redirect' => Env::get('BASE_URL') . '/sales-order'
            ], JSON_UNESCAPED_SLASHES);

        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $this->sales_order->softDelete($id);
            echo json_encode(['status' => true, 'message' => 'Sales Order dihapus']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
