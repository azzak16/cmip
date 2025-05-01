<?php 
namespace App\Controllers;

use App\Models\Product;
use App\Models\SalesOrder;
use Core\Controller;
use Core\Validator;
use Core\Auth;
use Core\Database;
use Core\Env;
use Exception;

class SalesOrderController extends Controller
{
    private $salesOrderModel;

    public function __construct()
    {
        $this->salesOrderModel = new SalesOrder();
    }

    public function index()
    {
        $this->view('sales-order/index', ['title' => 'Sales Order'], 'layouts/main');
    }

    public function ajaxList()
    {
        header('Content-Type: application/json');
        echo json_encode($this->salesOrderModel->all());
    }

    public function data()
    {
        $model = new SalesOrder();
        $sales_orders = $model->all();
        echo json_encode(['data' => $sales_orders]);
    }

    public function create()
    {
        $this->view('sales-order/create', ['title' => 'Tambah Sales Order'], 'layouts/main');
    }

    public function store()
    {
        $db = Database::getInstance();
        $db->beginTransaction();

        try {
            $errors = Validator::validate($_POST, [
                'name' => 'required|min:3',
                'description' => 'required'
            ]);

            if ($errors) {
                throw new \Exception(json_encode($errors));
            }

            $model = new SalesOrder();
            $model->insert([
                // 'tenant_id' => Auth::user()['tenant_id'],
                'name' => $_POST['name'],
                'description' => $_POST['description']
            ]);

            // Upload multiple files
            // foreach ($files['images']['tmp_name'] as $i => $tmp) {
            //     if ($tmp === '') continue;

            //     $filename = time() . '_' . basename($files['images']['name'][$i]);
            //     $dest = __DIR__ . '/../../public/uploads/sales-order/' . $filename;

            //     if (!move_uploaded_file($tmp, $dest)) {
            //         throw new Exception("Gagal upload gambar.");
            //     }

            //     $this->model->addImage($productId, $filename);
            // }

            $db->commit();
            echo json_encode([
                'status' => true, 
                'message' => 'Sales Order berhasil disimpan.',
                'redirect' => Env::get('BASE_URL') . '/sales-order'
            ], JSON_UNESCAPED_SLASHES);

        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $model = new SalesOrder();
        $product = $model->find($id);

        $this->view('sales-order/edit', ['title' => 'Edit Sales Order', 'Sales Order' => $product], 'layouts/main');
    }

    public function update($id)
    {
        $db = Database::getInstance();
        $db->beginTransaction();

        try {
            $errors = Validator::validate($_POST, [
                'name' => 'required|min:3',
                'description' => 'required'
            ]);

            if ($errors) {
                throw new \Exception(json_encode($errors));
            }

            $model = new SalesOrder();
            $model->update($id, [
                'name' => $_POST['name'],
                'description' => $_POST['description']
            ]);

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

    // public function delete($id)
    // {
    //     try {
    //         $this->service->deleteProduct($id);
    //         echo json_encode(['success' => true, 'message' => 'Sales Order dihapus.']);
    //     } catch (Exception $e) {
    //         http_response_code(500);
    //         echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }

    public function delete($id)
    {
        try {
            $model = new SalesOrder();
            $model->softDelete($id);
            echo json_encode(['status' => true, 'message' => 'Sales Order dihapus']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
