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
}
