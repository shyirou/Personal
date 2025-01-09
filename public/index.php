<?php

$page = $_GET['page'] ?? null;

switch ($page) {
    case 'add':
        require_once __DIR__ . "/pages/add.php";
        break;
    case 'home':
        require_once __DIR__ . "/pages/home.php";
        break;
    case 'edit':
        require_once __DIR__ . "/pages/edit.php";
        break;
    case 'view':
        require_once __DIR__ . "/pages/view.php";
        break;
    default:
        require_once __DIR__ . "/pages/home.php";
        break;
}
