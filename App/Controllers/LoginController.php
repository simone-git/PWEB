<?php

namespace App\Controllers;

use App\Models\MySQL;


class LoginController extends BaseController {
    public function loginForm() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mysql = new MySQL($this->db_conn);
            
            if(!$mysql->connect())
                echo 'Not connected.<br>';

            if(!$mysql->execute('SELECT * FROM users'))
                echo 'Query failed.<br>';

            echo json_encode($mysql->fetch());

            $mysql->close();
        }


        return $this->renderView('login', ['METHOD' => $_SERVER['REQUEST_METHOD']]);
    }
};
