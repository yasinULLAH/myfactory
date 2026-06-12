<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Helpers\CaptchaHelper;

class CaptchaController extends Controller {
    public function show() {
        $equation = CaptchaHelper::generate();
        CaptchaHelper::render($equation);
    }
}
