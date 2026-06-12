<?php
namespace App\Controllers;
use App\Core\Controller;
class SalesController extends Controller {
    public function index() {
        $this->checkPermission('Sales', 'read');
        $data = ['title' => 'Sales & Dispatch'];
        $this->view('sales/index', $data);
    }
}
