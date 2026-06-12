<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\QC;
class QCController extends Controller {
    public function index() {
        $this->checkAuth();
        $model = new QC();
        $data = ['title' => 'Quality Control', 'records' => $model->getAll()];
        $this->view('qc/index', $data);
    }
}