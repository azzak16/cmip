<?php 
namespace App\Controllers;

use App\Models\Customer;
use Core\Controller;
use Core\Validator;
use Core\Auth;
use Core\Database;
use Core\Env;
use Exception;

class CustomerController extends Controller
{
    private $customer;
    private $data;

    public function __construct()
    {
        $this->customer = new Customer();
        $this->data = [
            'title' => 'Customer',
        ];
    }

    public function index()
    {
        $this->view('customer/index', $this->data, 'layouts/main');
    }

    public function ajaxList()
    {
        header('Content-Type: application/json');
        echo json_encode($this->customer->all());
    }

    public function data()
    {
        $model = new Product();
        $products = $model->all();
        echo json_encode(['data' => $products]);
    }

    public function create()
    {
        $this->view('product/create', ['title' => 'Tambah Produk'], 'layouts/main');
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

            $model = new Product();
            $model->insert([
                // 'tenant_id' => Auth::user()['tenant_id'],
                'name' => $_POST['name'],
                'description' => $_POST['description']
            ]);

            // Upload multiple files
            // foreach ($files['images']['tmp_name'] as $i => $tmp) {
            //     if ($tmp === '') continue;

            //     $filename = time() . '_' . basename($files['images']['name'][$i]);
            //     $dest = __DIR__ . '/../../public/uploads/products/' . $filename;

            //     if (!move_uploaded_file($tmp, $dest)) {
            //         throw new Exception("Gagal upload gambar.");
            //     }

            //     $this->model->addImage($productId, $filename);
            // }

            $db->commit();
            echo json_encode([
                'status' => true, 
                'message' => 'Produk berhasil disimpan.',
                'redirect' => Env::get('BASE_URL') . '/products'
            ], JSON_UNESCAPED_SLASHES);

        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $model = new Product();
        $product = $model->find($id);

        $this->view('product/edit', ['title' => 'Edit Produk', 'product' => $product], 'layouts/main');
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

            $model = new Product();
            $model->update($id, [
                'name' => $_POST['name'],
                'description' => $_POST['description']
            ]);

            $db->commit();
            echo json_encode([
                'status' => true, 
                'message' => 'Produk berhasil dirubah.',
                'redirect' => Env::get('BASE_URL') . '/products'
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
    //         echo json_encode(['success' => true, 'message' => 'Produk dihapus.']);
    //     } catch (Exception $e) {
    //         http_response_code(500);
    //         echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }

    public function delete($id)
    {
        try {
            $model = new Product();
            $model->softDelete($id);
            echo json_encode(['status' => true, 'message' => 'Produk dihapus']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
