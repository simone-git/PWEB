<?php

namespace App\Controllers;

use App\Models\MySQL;


class AuthController extends BaseController {
    public function registerForm() {
        return $this->renderView('register');
    }

    public function register() {
        $mysql = new MySQL($this->db_conn);
        
        if(!$mysql->connect())
            echo 'Not connected.<br>';


        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

        if(!$email || !$password) {
            
        }


        if(!$mysql->execute('SELECT * FROM users'))
            echo 'Query failed.<br>';

        echo json_encode($mysql->fetch());

        $mysql->close();
    }


    public function loginForm() {
        return $this->renderView('login');
    }

    public function login() {
        $mysql = new MySQL($this->db_conn);
        
        if(!$mysql->connect())
            echo 'Not connected.<br>';

        if(!$mysql->execute('SELECT * FROM users'))
            echo 'Query failed.<br>';

        echo json_encode($mysql->fetch());

        $mysql->close();
    }
};
