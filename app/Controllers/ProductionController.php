<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\BOM;
use App\Models\Product;

class ProductionController extends Controller {
    public function bom() {
        $this->checkPermission('Production', 'read');
        $model = new BOM();
        $productModel = new Product();
        $data = [
            'title' => 'Bill of Materials',
            'boms' => $model->getAll(),
            'products' => $productModel->getAll()
        ];
        $this->view('production/bom', $data);
    }

    public function saveBOM() {
        $this->checkPermission('Production', 'create');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request'], 405);
        }

        $items = [];
        foreach ($_POST['material_id'] as $key => $val) {
            $items[] = [
                'material_id' => $val,
                'quantity' => (float)$_POST['quantity'][$key]
            ];
        }

        $data = [
            'product_id' => $_POST['product_id'],
            'name' => $_POST['name'],
            'version' => $_POST['version'] ?? '1.0'
        ];

        $model = new BOM();
        if ($model->createWithItems($data, $items)) {
            $this->json(['success' => true, 'message' => 'BOM created successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to create BOM']);
        }
    }
}
