<?php 
namespace App\Controllers;

use App\Models\Images;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\Role;
use Core\Controller;
use Core\Validator;
use Core\Auth;
use Core\Database;
use Core\Env;
use Core\Model;
use Exception;
use PDO;

class RoleController extends Controller
{
    private $role;
    private $data;

    public function __construct()
    {
        if (!Auth::check()) {
            $this->redirect('/cmip/login');
        }
        
        $this->role = new Role();
        $this->data = [
            'title' => 'Role',
        ];
    }

    public function index()
    {
        $this->view('role/index', $this->data, 'layouts/main');
    }

    public function ajaxList()
    {
        header('Content-Type: application/json');
        echo json_encode($this->role->all());
    }

    public function data()
    {
        $roles = $this->role->all();
        echo json_encode(['data' => $roles]);
    }

    public function create()
    {
        $this->view('role/create', $this->data, 'layouts/main');
    }

    public function store()
    {
        
        $db = Database::getInstance();
        $db->beginTransaction();

        try {

            $role_id = $this->role->insert([
                'name' => $_POST['name'],
                'description' => $_POST['description'],
            ]);


            $db->commit();
            echo json_encode([
                'status' => true, 
                'message' => 'Role berhasil disimpan.',
                'redirect' => Env::get('BASE_URL') . '/role'
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
        $result = $this->role->raw(
            "SELECT roles.*, customers.CS_NAMA, customers.CS_KODE
                FROM roles
                left join customers on roles.customer_id = customers.NO_ID
                WHERE roles.id = $id"
        );
        $this->data['roles'] = $result->fetchAll(PDO::FETCH_ASSOC);

        $result = $this->role->raw(
            "SELECT *
                FROM role_items
                WHERE role_id = $id"
        );
        $this->data['role_items'] = $result->fetchAll(PDO::FETCH_ASSOC);

        $result = $this->role->raw(
            "SELECT *
                FROM role_images
                WHERE role_id = $id"
        );
        $this->data['role_images'] = $result->fetchAll(PDO::FETCH_ASSOC);

        $this->view('role/edit', $this->data, 'layouts/main');
    }

    public function print($id)
    {
        $this->data['role'] = $this->role->find($id);

        $this->view('role/print', $this->data, 'layouts/main');
    }
    

    public function update($id)
    {

        $db = Database::getInstance();
        $db->beginTransaction();
        
        $date = date('Y-m-d', strtotime($_POST['order_date']));
        
        $orde_number = $this->role->number($date);
        $production_code = $this->role->code($_POST['customer_id'], $date);

        $deletedItems = json_decode($_POST['deleted_items'] ?? '[]', true);
        $deletedImages = json_decode($_POST['deleted_images'] ?? '[]', true);

        try {
            
            $this->role->update([
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
                $this->role->raw("DELETE FROM role_items WHERE id IN (" . implode(',', $deletedItems) . ") AND role_id = $id");                
            }

            foreach ($_POST['product_desc'] as $key => $value) {

                if (isset($_POST['item_id'][$key])) {
                    $model_item = new SalesOrderItem();
                    $model_item->update([
                        'role_id' => $id,    
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
                        'role_id' => $id,
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
                $stmt = $this->role->raw("SELECT file_name FROM role_images WHERE id IN (" . implode(',', $deletedImages) . ") AND role_id = $id");
                $filesToDelete = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                $stmt = $this->role->raw("DELETE FROM role_images WHERE id IN (" . implode(',', $deletedImages) . ") AND role_id = $id");

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

                    $stmt = $this->role->raw("SELECT file_name FROM role_images WHERE file_name = '" . $files['name'][$i] . "'  AND role_id = $id");
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
                                $upload_image->addImage('role_images', 'role_id', $id, $fileName);
                                
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
                'message' => 'Role berhasil dirubah.',
                'redirect' => Env::get('BASE_URL') . '/role'
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
            $this->role->softDelete($id);
            echo json_encode(['status' => true, 'message' => 'Role dihapus']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
