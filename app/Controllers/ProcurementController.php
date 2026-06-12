<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Product;

class ProcurementController extends Controller {
    public function index() {
        $this->checkPermission('Procurement', 'read');
        $model = new PurchaseOrder();
        $data = ['title' => 'Purchase Orders', 'orders' => $model->getAll()];
        $this->view('procurement/index', $data);
    }

    public function create() {
        $this->checkPermission('Procurement', 'create');
        $supplierModel = new Supplier();
        $productModel = new Product();
        $data = [
            'title' => 'Create Purchase Order',
            'suppliers' => $supplierModel->getAll(),
            'products' => $productModel->getAll()
        ];
        $this->view('procurement/create', $data);
    }

    public function store() {
        $this->checkPermission('Procurement', 'create');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request'], 405);
        }

        $items = [];
        $totalAmount = 0;
        foreach ($_POST['product_id'] as $key => $val) {
            $qty = (float)$_POST['quantity'][$key];
            $price = (float)$_POST['unit_price'][$key];
            $items[] = [
                'product_id' => $val,
                'quantity' => $qty,
                'unit_price' => $price
            ];
            $totalAmount += ($qty * $price);
        }

        $data = [
            'supplier_id' => $_POST['supplier_id'],
            'po_number' => 'PO-' . time(),
            'order_date' => $_POST['order_date'],
            'total_amount' => $totalAmount
        ];

        $model = new PurchaseOrder();
        $poId = $model->createWithItems($data, $items);

        if ($poId) {
            $this->json(['success' => true, 'message' => 'Purchase Order created successfully', 'redirect' => '/procurement']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to create Purchase Order']);
        }
    }

    public function viewOrder() {
        $this->checkPermission('Procurement', 'read');
        $id = $_GET['id'] ?? null;
        $model = new PurchaseOrder();
        $order = $model->getById($id);
        if (!$order) die('Order not found');
        
        $items = $model->getItems($id);
        $data = ['title' => 'View PO: ' . $order['po_number'], 'order' => $order, 'items' => $items];
        $this->view('procurement/view', $data);
    }
}
