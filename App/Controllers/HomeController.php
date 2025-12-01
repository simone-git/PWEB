<?php

namespace App\Controllers;

use App\Controllers\BaseController;


class HomeController extends BaseController {
    public function index() {
        return $this->renderView('home', ['TITLE' => 'Hello World 2']);
    }
}
