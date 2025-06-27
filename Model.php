<?php
// app/Core/Model.php

require_once BASE_PATH . '/config/database.php';

class Model {
    public $db; // PDO

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
}
