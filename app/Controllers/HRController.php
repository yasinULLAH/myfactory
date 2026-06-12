<?php
namespace App\Controllers;
use App\Core\Controller;
class HRController extends Controller {
    public function index() {
        $this->checkAuth();
        $data = ['title' => 'HR & Attendance'];
        $this->view('hr/index', $data);
    }
}