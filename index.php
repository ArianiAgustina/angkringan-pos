<?php
// index.php

// Atur kesalahan tampil (development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', __DIR__);
// Autoload sederhana: include file kelas secara manual
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/Core/Router.php';
require_once BASE_PATH . '/app/Core/Controller.php';
require_once BASE_PATH . '/app/Core/Model.php';

// Jalankan router, dsb.
$router = new Router();
$router->route();
