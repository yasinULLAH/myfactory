<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Factory;
use App\Models\Product;
use App\Models\Supplier;

class MasterDataController extends Controller {
    
    // --- Factories ---
    public function factories() {
        $this->checkAuth();
        $model = new Factory();
        $data = ['title' => 'Factories', 'factories' => $model->getAll()];
        $this->view('master/factories', $data);
    }

    public function getFactory() {
        $this->checkAuth();
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
        $this->checkAuth();
        $id = $_POST['id'] ?? null;
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
        $this->checkAuth();
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
        $this->checkAuth();
        $model = new Product();
        $data = ['title' => 'Products', 'products' => $model->getAll()];
        $this->view('master/products', $data);
    }

    public function getProduct() {
        $this->checkAuth();
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
        $this->checkAuth();
        $id = $_POST['id'] ?? null;
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
        $this->checkAuth();
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
        $this->checkAuth();
        $model = new Supplier();
        $data = ['title' => 'Suppliers', 'suppliers' => $model->getAll()];
        $this->view('master/suppliers', $data);
    }

    public function getSupplier() {
        $this->checkAuth();
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
        $this->checkAuth();
        $id = $_POST['id'] ?? null;
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
        $this->checkAuth();
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
