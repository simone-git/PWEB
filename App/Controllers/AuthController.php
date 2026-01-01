<?php

namespace App\Controllers;

use App\Models\MySQL;
use Exception;
use Library\Utils;

class AuthController extends BaseController {
    public function registerForm() {
        if($this->checkSession()) {
            header("Location: /");
        }

        return $this->renderView('register');
    }

    public function register() {
        if($this->checkSession()) {
            return self::httpResponse(["redirect" => "/"]);
        }


        $mysql = new MySQL($this->db_conn);
        
        if(!$mysql->connect())
            throw new Exception("Il database è offline", 500);

        if(!$args = Utils::reqInput())
                throw new Exception("Fornire un input valido", 400);

        $username = $args["usr"] ?? '';
        $password = $args["pwd"] ?? '';

        if(!Utils::hasValue($username) || !Utils::hasValue($password))
                throw new Exception("Campi non specificati", 400);


        if(!$mysql->execute('SELECT COUNT(*) AS taken FROM users WHERE username LIKE ?', 's', $username))
            throw new Exception("Query non valida", 500);

        if(($mysql->fetch())[0]["taken"]) {
            throw new Exception("Username non disponibile", 400);
        } else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            if(!$mysql->execute('INSERT INTO users (username, password) VALUES (?, ?)', 'ss', $username, $password_hash))
                throw new Exception("Query non valida", 500);
        }


        session_regenerate_id(true);
        $_SESSION['session_id'] = session_id();

        return self::httpResponse(["redirect" => "/"]);
    }


    public function loginForm() {
        if($this->checkSession()) {
            header("Location: /");
        }

        return $this->renderView('login');
    }

    public function login() {
        if($this->checkSession()) {
            return self::httpResponse(["redirect" => "/"]);
        }

        $mysql = new MySQL($this->db_conn);
        
        if(!$mysql->connect())
            throw new Exception("Il database è offline", 500);

        $args = Utils::reqInput();
        if(!$args)
            throw new Exception("Fornire un input valido", 400);

        $username = $args["usr"] ?? '';
        $password = $args["pwd"] ?? '';

        if(!Utils::hasValue($username) || !Utils::hasValue($password)) {
            throw new Exception("Campi non specificati", 400);
        }

        if(!$mysql->execute('SELECT password FROM users WHERE username LIKE ?', 's', $username))
            throw new Exception("Query non valida", 500);

        $result = $mysql->fetch();
        if(count($result) < 1 || !password_verify($password, $result[0]["password"]))
            throw new Exception("Login non corretto", 400);
        

        session_regenerate_id(true);
        $_SESSION['session_id'] = session_id();
        
        return self::httpResponse(["redirect" => "/"]);
    }


    public function logout() {
        session_destroy();
        header("Location: /login");
    }
};
