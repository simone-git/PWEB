<?php

namespace App\Controllers;

use Library\Processor;


class BaseController {
    protected Processor $processor;

    protected array $baseViewParams;
    protected array $db_conn;


    public function __construct() {
        $this->baseViewParams = [
            'TITLE' => 'Hello World'
        ];

        $this->db_conn = [
            'HOST' => CONFIG['DB_HOST'],
            'USER' => CONFIG['DB_USER'],
            'PWD' => CONFIG['DB_PWD'],
            'DB_NAME' => CONFIG['DB_NAME']
        ];
    }

    
    protected function renderView(string $name, array $params = []) {
        $this->processor = new Processor(VIEWS_PATH);

        return $this->processor->render($name, array_merge($this->baseViewParams, $params));
    }

    public static function httpResponse(array $payload, int $code = 200): string {
        http_response_code($code);
        return json_encode($payload);
    }

    protected function checkSession() {
        $id = $_SESSION["session_id"] ?? '';
        return isset($_SESSION["session_id"]) && $id == session_id();
    }
}
