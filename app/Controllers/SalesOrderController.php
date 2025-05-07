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

        $orde_number = $this->sales_order->number($_POST['order_date']);
        $production_code = $this->sales_order->code($_POST['customer_id'], $_POST['order_date']);

        try {

            $so_id = $this->sales_order->insert([
                // 'tenant_id' => Auth::user()['tenant_id'],
                'customer_id' => $_POST['customer_id'],
                'karat' => $_POST['karat_id'],
                'production_code' => $_POST['production_code']?: $production_code,
                'order_number' => $_POST['order_number']?: $orde_number,
                'order_date' => $_POST['order_date'],
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
                    'sales_order_number' => $_POST['order_number']?: $orde_number,
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
            "SELECT *
                FROM sales_orders
                left join sales_order_items on sales_orders.order_number = sales_order_items.sales_order_number
                WHERE sales_orders.id = $id"
        );

        $items = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($items);
        die();

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
