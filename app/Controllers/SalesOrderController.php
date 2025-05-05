<?php 
namespace App\Controllers;

use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use Core\Controller;
use Core\Validator;
use Core\Auth;
use Core\Database;
use Core\Env;
use Exception;

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

        try {

            $so_id = $this->sales_order->insert([
                // 'tenant_id' => Auth::user()['tenant_id'],
                'customer_name' => $_POST['customer_name'],
                'customer_code' => $_POST['customer_code'],
                'customer_address' => $_POST['customer_address'],
                'production_code' => $_POST['production_code'],
                'order_number' => $_POST['order_number'],
                'order_date' => $_POST['order_date'],
                'payment_terms' => $_POST['payment_terms'],
                'delivery_plan' => $_POST['delivery_plan'],
                'manager_production' => $_POST['manager_production'],
                'ppic' => $_POST['ppic'],
                'head_sales' => $_POST['head_sales'],
                'order_recipient' => $_POST['order_recipient'],
            ]);

            foreach ($_POST['product_name'] as $key => $value) {
                $model_item = new SalesOrderItem();
                $model_item->insert([
                    'sales_order_id' => $so_id,
                    'product_name' => $_POST['product_name'][$key],
                    'color' => $_POST['color'][$key],
                    'karat' => $_POST['karat'][$key],
                    'pcs' => $_POST['pcs'][$key],
                    'pairs' => $_POST['pairs'][$key],
                    'gram' => $_POST['gram'][$key],
                    'note' => $_POST['note'][$key],
                ]);
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
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $this->data['sales_order'] = $this->sales_order->find($id);

        $this->view('sales-order/edit', $this->sales_order, 'layouts/main');
    }

    public function print($id)
    {
        $this->data['sales_order'] = $this->sales_order->find($id);

        $this->view('sales-order/print', $this->sales_order, 'layouts/main');
    }
    

    public function update($id)
    {
        $db = Database::getInstance();
        $db->beginTransaction();

        try {

            
            $this->sales_order->update($id, [
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
            $this->sales_order->softDelete($id);
            echo json_encode(['status' => true, 'message' => 'Sales Order dihapus']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
