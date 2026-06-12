<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\Factory;
use App\Models\Product;

class InventoryController extends Controller {
    
    // --- Warehouses ---
    public function warehouses() {
        $this->checkPermission('Inventory', 'read');
        $model = new Warehouse();
        $factoryModel = new Factory();
        $data = [
            'title' => 'Warehouses', 
            'warehouses' => $model->getAll(),
            'factories' => $factoryModel->getAll()
        ];
        $this->view('inventory/warehouses', $data);
    }

    public function getWarehouse() {
        $this->checkPermission('Inventory', 'read');
        $id = $_GET['id'] ?? null;
        if (!$id) $this->json(['success' => false, 'message' => 'ID missing'], 400);
        $model = new Warehouse();
        $warehouse = $model->getById($id);
        if ($warehouse) {
            $this->json(['success' => true, 'data' => $warehouse]);
        } else {
            $this->json(['success' => false, 'message' => 'Warehouse not found'], 404);
        }
    }

    public function saveWarehouse() {
        $id = $_POST['id'] ?? null;
        $this->checkPermission('Inventory', $id ? 'update' : 'create');
        $data = [
            'factory_id' => $_POST['factory_id'],
            'name' => $_POST['name'],
            'location' => $_POST['location']
        ];
        $model = new Warehouse();
        if ($id) {
            $result = $model->update($id, $data);
            $message = 'Warehouse updated successfully';
        } else {
            $result = $model->create($data);
            $message = 'Warehouse created successfully';
        }

        if ($result) {
            $this->json(['success' => true, 'message' => $message]);
        } else {
            $this->json(['success' => false, 'message' => 'Operation failed']);
        }
    }

    public function deleteWarehouse() {
        $this->checkPermission('Inventory', 'delete');
        $id = $_POST['id'] ?? null;
        if (!$id) $this->json(['success' => false, 'message' => 'ID missing'], 400);
        $model = new Warehouse();
        if ($model->delete($id)) {
            $this->json(['success' => true, 'message' => 'Warehouse deleted successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Delete failed']);
        }
    }

    // --- Stock ---
    public function stock() {
        $this->checkPermission('Inventory', 'read');
        $model = new Stock();
        $warehouseModel = new Warehouse();
        $productModel = new Product();
        $data = [
            'title' => 'Stock', 
            'stock' => $model->getAll(),
            'warehouses' => $warehouseModel->getAll(),
            'products' => $productModel->getAll()
        ];
        $this->view('inventory/stock', $data);
    }

    public function getStock() {
        $this->checkPermission('Inventory', 'read');
        $id = $_GET['id'] ?? null;
        if (!$id) $this->json(['success' => false, 'message' => 'ID missing'], 400);
        $model = new Stock();
        $stock = $model->getById($id);
        if ($stock) {
            $this->json(['success' => true, 'data' => $stock]);
        } else {
            $this->json(['success' => false, 'message' => 'Stock not found'], 404);
        }
    }

    public function saveStock() {
        $id = $_POST['id'] ?? null;
        $this->checkPermission('Inventory', $id ? 'update' : 'create');
        $data = [
            'warehouse_id' => $_POST['warehouse_id'],
            'product_id' => $_POST['product_id'],
            'batch_number' => $_POST['batch_number'],
            'quantity' => $_POST['quantity'],
            'expiry_date' => !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null
        ];
        $model = new Stock();
        if ($id) {
            $result = $model->update($id, $data);
            $message = 'Stock updated successfully';
        } else {
            $result = $model->create($data);
            $message = 'Stock added successfully';
        }

        if ($result) {
            $this->json(['success' => true, 'message' => $message]);
        } else {
            $this->json(['success' => false, 'message' => 'Operation failed']);
        }
    }

    public function deleteStock() {
        $this->checkPermission('Inventory', 'delete');
        $id = $_POST['id'] ?? null;
        if (!$id) $this->json(['success' => false, 'message' => 'ID missing'], 400);
        $model = new Stock();
        if ($model->delete($id)) {
            $this->json(['success' => true, 'message' => 'Stock deleted successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Delete failed']);
        }
    }
}
