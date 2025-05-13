<?php 
namespace App\Controllers;

use App\Models\Customer;
use Core\Controller;
use Core\Validator;
use Core\Auth;
use Core\Database;
use Core\Env;
use Exception;
use PDO;

class CustomerController extends Controller
{
    private $customer;
    private $data;

    public function __construct()
    {
        if (!Auth::check()) {
            $this->redirect('/cmip/login');
        }
        
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
        $customers = $this->customer->all();
        echo json_encode(['data' => $customers]);
    }

    public function select()
    {
        $search = $_GET['search'] ?? '';
        $page = (int)($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $stmt = $this->customer->raw("SELECT count(*)
                FROM customers
                WHERE AKTIF = 1
                AND CS_NAMA LIKE '%$search%'
                AND CS_NAMA != ''
                ORDER BY CS_NAMA");
        $stmt->execute();
        $total = $stmt->fetchColumn();

        $results = $this->customer->raw("SELECT *
                FROM customers
                WHERE AKTIF = 1
                AND CS_NAMA LIKE '%$search%'
                AND CS_NAMA != ''
                ORDER BY CS_NAMA LIMIT $limit OFFSET $offset");
        $items = $results->fetchAll(PDO::FETCH_ASSOC);

        $selectajax = [];
        foreach ($items as $row) {
            $selectajax[] = array(
                'id' => $row['NO_ID'],
                'text' => $row['CS_NAMA'],
            );
        }

        echo json_encode([
            'hasMore' => ($offset + $limit) < $total,
            'items' => $selectajax
        ]);
    }

    public function create()
    {
        $this->view('customer/create', $this->data, 'layouts/main');
    }

    public function store()
    {
        $db = Database::getInstance();
        $db->beginTransaction();

        try {

            $this->customer->insert([
                // 'tenant_id' => Auth::user()['tenant_id'],
                'CS_NAMA' => $_POST['CS_NAMA'],
                'CS_KODE' => $_POST['CS_KODE'],
                'CS_ALAMAT' => $_POST['CS_ALAMAT'],
                'NOTES' => $_POST['NOTES'],
                'AKTIF' => 1,
            ], 'NO_ID');

            $db->commit();
            echo json_encode([
                'status' => true, 
                'message' => 'Customer berhasil disimpan.',
                'redirect' => Env::get('BASE_URL') . '/customer'
            ], JSON_UNESCAPED_SLASHES);

        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $this->data['customer'] = $this->customer->find($id, 'NO_ID', FALSE);

        $this->view('customer/edit', $this->data, 'layouts/main');
    }

    public function update($id)
    {
        $db = Database::getInstance();
        $db->beginTransaction();

        try {

            $this->customer->update([
                'CS_NAMA' => $_POST['CS_NAMA'],
                'CS_KODE' => $_POST['CS_KODE'],
                'CS_ALAMAT' => $_POST['CS_ALAMAT'],
                'NOTES' => $_POST['NOTES'],
            ], $id, 'NO_ID');

            $db->commit();
            echo json_encode([
                'status' => true, 
                'message' => 'Customer berhasil dirubah.',
                'redirect' => Env::get('BASE_URL') . '/customer'
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
    //         echo json_encode(['success' => true, 'message' => 'customer dihapus.']);
    //     } catch (Exception $e) {
    //         http_response_code(500);
    //         echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }

    public function delete($id)
    {
        try {
            $this->customer->delete($id, 'NO_ID');
            echo json_encode(['status' => true, 'message' => 'Customer dihapus']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
