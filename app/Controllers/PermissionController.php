<?php 
namespace App\Controllers;

use App\Models\Images;
use App\Models\Permission;
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

class PermissionController extends Controller
{
    private $permission;
    private $data;

    public function __construct()
    {
        if (!Auth::check()) {
            $this->redirect('/cmip/login');
        }
        
        $this->permission = new Permission();
        $this->data = [
            'title' => 'Permission',
        ];
    }

    public function index()
    {
        $this->view('permission/index', $this->data, 'layouts/main');
    }

    public function ajaxList()
    {
        header('Content-Type: application/json');
        echo json_encode($this->permission->all());
    }

    public function data()
    {
        $permissions = $this->permission->all();
        echo json_encode(['data' => $permissions]);
    }

    public function create()
    {
        $this->view('permission/create', $this->data, 'layouts/main');
    }

    public function store()
    {
        
        $db = Database::getInstance();
        $db->beginTransaction();

        try {

            $permission_id = $this->permission->insert([
                'name' => $_POST['name'],
                'description' => $_POST['description'],
            ]);

            $db->commit();
            echo json_encode([
                'status' => true, 
                'message' => 'Permission berhasil disimpan.',
                'redirect' => Env::get('BASE_URL') . '/permission'
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
        $result = $this->permission->raw(
            "SELECT permissions.*, customers.CS_NAMA, customers.CS_KODE
                FROM permissions
                left join customers on permissions.customer_id = customers.NO_ID
                WHERE permissions.id = $id"
        );
        $this->data['permissions'] = $result->fetchAll(PDO::FETCH_ASSOC);

        $result = $this->permission->raw(
            "SELECT *
                FROM permission_items
                WHERE permission_id = $id"
        );
        $this->data['permission_items'] = $result->fetchAll(PDO::FETCH_ASSOC);

        $result = $this->permission->raw(
            "SELECT *
                FROM permission_images
                WHERE permission_id = $id"
        );
        $this->data['permission_images'] = $result->fetchAll(PDO::FETCH_ASSOC);

        $this->view('permission/edit', $this->data, 'layouts/main');
    }

    public function print($id)
    {
        $this->data['permission'] = $this->permission->find($id);

        $this->view('permission/print', $this->data, 'layouts/main');
    }
    

    public function update($id)
    {

        $db = Database::getInstance();
        $db->beginTransaction();
        
        $date = date('Y-m-d', strtotime($_POST['order_date']));
        
        $orde_number = $this->permission->number($date);
        $production_code = $this->permission->code($_POST['customer_id'], $date);

        $deletedItems = json_decode($_POST['deleted_items'] ?? '[]', true);
        $deletedImages = json_decode($_POST['deleted_images'] ?? '[]', true);

        try {
            
            $this->permission->update([
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
                $this->permission->raw("DELETE FROM permission_items WHERE id IN (" . implode(',', $deletedItems) . ") AND permission_id = $id");                
            }

            foreach ($_POST['product_desc'] as $key => $value) {

                if (isset($_POST['item_id'][$key])) {
                    $model_item = new SalesOrderItem();
                    $model_item->update([
                        'permission_id' => $id,    
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
                        'permission_id' => $id,
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
                $stmt = $this->permission->raw("SELECT file_name FROM permission_images WHERE id IN (" . implode(',', $deletedImages) . ") AND permission_id = $id");
                $filesToDelete = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                $stmt = $this->permission->raw("DELETE FROM permission_images WHERE id IN (" . implode(',', $deletedImages) . ") AND permission_id = $id");

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

                    $stmt = $this->permission->raw("SELECT file_name FROM permission_images WHERE file_name = '" . $files['name'][$i] . "'  AND permission_id = $id");
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
                                $upload_image->addImage('permission_images', 'permission_id', $id, $fileName);
                                
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
                'message' => 'Permission berhasil dirubah.',
                'redirect' => Env::get('BASE_URL') . '/permission'
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
            $this->permission->softDelete($id);
            echo json_encode(['status' => true, 'message' => 'Permission dihapus']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
