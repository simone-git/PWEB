<?php

namespace App\Models;

use Error;
use Exception;
use mysqli, mysqli_stmt;


// Perché non server richiedere IDatabase?
class MySQL {
    private string $host, $username, $password, $database;

    private mysqli $connection;
    private mysqli_stmt $stmt;


    public function __construct(array $params) {
        $this->host = $params["HOST"];
        $this->username = $params["USER"];
        $this->password = $params["PWD"];
        $this->database = $params["DB_NAME"];

    }


    public function connect(): bool {
        try {
            $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        } catch(Exception) {  // Unreachable server or wrong credentials
            return false;
        }
        
        return true;
    }

    public function execute(string $query, string $types = '', string ...$params): bool {
        try {
            $this->stmt = $this->connection->prepare($query);
            
            if(!empty($types) && !empty($params))
                $this->stmt->bind_param($types, $params);

            return $this->stmt->execute();
        } catch(Error) {  // Closed connection
            return false;
        } catch(Exception) {  // Wrong arguments
            return false;
        }

        return true;
    }

    public function fetch(): array|false {
        try {
            $result = $this->stmt->get_result();

            if($result === false)
                return false;

            return $result->fetch_all(MYSQLI_ASSOC);
        } catch(Error) {  // No queries were executed
            return false;
        }
    }

    public function close() {
        try {
            $this->connection->close();
        } catch(Error) {}  // Already closed connection
    }
};
