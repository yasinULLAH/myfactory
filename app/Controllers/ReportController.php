<?php
namespace App\Controllers;
use App\Core\Controller;
class ReportController extends Controller {
    public function index() {
        $this->checkAuth();
        $data = ['title' => 'Reports & Analytics'];
        $this->view('reports/index', $data);
    }
}