<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Factory;
use App\Models\Product;
use App\Models\Supplier;

class MasterDataController extends Controller {
    
    // --- Factories ---
    public function factories() {
        $this->checkPermission('Master Data', 'read');
        $model = new Factory();
        $data = ['title' => 'Factories', 'factories' => $model->getAll()];
        $this->view('master/factories', $data);
    }

    public function getFactory() {
        $this->checkPermission('Master Data', 'read');
        $id = $_GET['id'] ?? null;
        if (!$id) $this->json(['success' => false, 'message' => 'ID missing'], 400);
        $model = new Factory();
        $factory = $model->getById($id);
        if ($factory) {
            $this->json(['success' => true, 'data' => $factory]);
        } else {
            $this->json(['success' => false, 'message' => 'Factory not found'], 404);
        }
    }

    public function saveFactory() {
        $id = $_POST['id'] ?? null;
        $this->checkPermission('Master Data', $id ? 'update' : 'create');
        $data = [
            'name' => $_POST['name'],
            'location' => $_POST['location'],
            'contact_number' => $_POST['contact_number'],
            'status' => $_POST['status'] ?? 'active'
        ];
        $model = new Factory();
        if ($id) {
            $result = $model->update($id, $data);
            $message = 'Factory updated successfully';
        } else {
            $result = $model->create($data);
            $message = 'Factory created successfully';
        }

        if ($result) {
            $this->json(['success' => true, 'message' => $message]);
        } else {
            $this->json(['success' => false, 'message' => 'Operation failed']);
        }
    }

    public function deleteFactory() {
        $this->checkPermission('Master Data', 'delete');
        $id = $_POST['id'] ?? null;
        if (!$id) $this->json(['success' => false, 'message' => 'ID missing'], 400);
        $model = new Factory();
        if ($model->delete($id)) {
            $this->json(['success' => true, 'message' => 'Factory deleted successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Delete failed']);
        }
    }

    // --- Products ---
    public function products() {
        $this->checkPermission('Master Data', 'read');
        $model = new Product();
        $data = ['title' => 'Products', 'products' => $model->getAll()];
        $this->view('master/products', $data);
    }

    public function getProduct() {
        $this->checkPermission('Master Data', 'read');
        $id = $_GET['id'] ?? null;
        if (!$id) $this->json(['success' => false, 'message' => 'ID missing'], 400);
        $model = new Product();
        $product = $model->getById($id);
        if ($product) {
            $this->json(['success' => true, 'data' => $product]);
        } else {
            $this->json(['success' => false, 'message' => 'Product not found'], 404);
        }
    }

    public function saveProduct() {
        $id = $_POST['id'] ?? null;
        $this->checkPermission('Master Data', $id ? 'update' : 'create');
        $data = [
            'sku' => $_POST['sku'],
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'reorder_level' => $_POST['reorder_level'],
            'price' => $_POST['price'],
            'status' => $_POST['status'] ?? 'active'
        ];
        $model = new Product();
        if ($id) {
            $result = $model->update($id, $data);
            $message = 'Product updated successfully';
        } else {
            $result = $model->create($data);
            $message = 'Product created successfully';
        }

        if ($result) {
            $this->json(['success' => true, 'message' => $message]);
        } else {
            $this->json(['success' => false, 'message' => 'Operation failed']);
        }
    }

    public function deleteProduct() {
        $this->checkPermission('Master Data', 'delete');
        $id = $_POST['id'] ?? null;
        if (!$id) $this->json(['success' => false, 'message' => 'ID missing'], 400);
        $model = new Product();
        if ($model->delete($id)) {
            $this->json(['success' => true, 'message' => 'Product deleted successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Delete failed']);
        }
    }

    // --- Suppliers ---
    public function suppliers() {
        $this->checkPermission('Master Data', 'read');
        $model = new Supplier();
        $data = ['title' => 'Suppliers', 'suppliers' => $model->getAll()];
        $this->view('master/suppliers', $data);
    }

    public function getSupplier() {
        $this->checkPermission('Master Data', 'read');
        $id = $_GET['id'] ?? null;
        if (!$id) $this->json(['success' => false, 'message' => 'ID missing'], 400);
        $model = new Supplier();
        $supplier = $model->getById($id);
        if ($supplier) {
            $this->json(['success' => true, 'data' => $supplier]);
        } else {
            $this->json(['success' => false, 'message' => 'Supplier not found'], 404);
        }
    }

    public function saveSupplier() {
        $id = $_POST['id'] ?? null;
        $this->checkPermission('Master Data', $id ? 'update' : 'create');
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'status' => $_POST['status'] ?? 'active'
        ];
        $model = new Supplier();
        if ($id) {
            $result = $model->update($id, $data);
            $message = 'Supplier updated successfully';
        } else {
            $result = $model->create($data);
            $message = 'Supplier created successfully';
        }

        if ($result) {
            $this->json(['success' => true, 'message' => $message]);
        } else {
            $this->json(['success' => false, 'message' => 'Operation failed']);
        }
    }

    public function deleteSupplier() {
        $this->checkPermission('Master Data', 'delete');
        $id = $_POST['id'] ?? null;
        if (!$id) $this->json(['success' => false, 'message' => 'ID missing'], 400);
        $model = new Supplier();
        if ($model->delete($id)) {
            $this->json(['success' => true, 'message' => 'Supplier deleted successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Delete failed']);
        }
    }
}
