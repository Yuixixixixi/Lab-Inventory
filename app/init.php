<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/App.php';

// Memuat seluruh Model secara global
require_once __DIR__ . '/models/InventoryModel.php';
require_once __DIR__ . '/models/TransactionModel.php';
require_once __DIR__ . '/models/UserModel.php';