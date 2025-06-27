<?php
// config/database.php

class Database {
    private $host = "localhost";
    private $db_name = "db_angkringan";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password
            );
            // Atur mode error ke exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Koneksi Database Error: " . $exception->getMessage();
            exit;
        }
        return $this->conn;
    }
}
