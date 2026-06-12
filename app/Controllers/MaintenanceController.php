<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Machine;
class MaintenanceController extends Controller {
    public function index() {
        $this->checkAuth();
        $model = new Machine();
        $data = ['title' => 'Machine Maintenance', 'machines' => $model->getAll()];
        $this->view('maintenance/index', $data);
    }
}