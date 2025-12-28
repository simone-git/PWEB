<?php

namespace App\Controllers;

use App\Controllers\BaseController;


class HomeController extends BaseController {
    public function index() {
        return $this->renderView('home', ['TITLE' => 'Hello World 2']);
    }


    public function home() {
        if(isset($_SESSION['session_id']))
            echo $_SESSION['session_id'];
        else
            echo "<a href='/signati'>Non signato.</a>";
    }

    public function signati() {
        // Check non già signato

        $_SESSION['session_id'] = session_id();
        session_regenerate_id(true);  // false splitta la sessione
    }

    public function esci() {
        session_destroy();
    }
}
