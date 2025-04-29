<?php 
namespace App\Controllers;

use App\Models\Product;
use Core\Controller;
use Core\Validator;
use Core\Auth;
use Core\Database;
use Core\Env;
use Exception;

class ProductController extends Controller
{
    public function index()
    {
        $this->view('product/index', ['title' => 'Product'], 'layouts/main');
    }

    public function data()
    {
        $model = new Product();
        $products = $model->allActiveByTenant(Auth::user()['tenant_id']);
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
            $db->commit();
            echo json_encode([
                'status' => 'success', 
                'message' => 'Produk berhasil disimpan.',
                'redirect' => Env::get('BASE_URL') . '/products'
            ], JSON_UNESCAPED_SLASHES);
        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $model = new Product();
        $model->softDelete($id);
        echo json_encode(['success' => true]);
    }
}
