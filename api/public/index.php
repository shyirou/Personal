<?php
require_once __DIR__ . '/database/db.php';

// Get the requested URI
$request = trim($_SERVER['REQUEST_URI'], '/');
$requestParts = explode('/', $request);

// Default page jika URL kosong
$page = $requestParts[0] ?? 'home';

// Tangani kasus root path (localhost:8000)
if (empty($page)) {
    $page = 'home';
}

// Capture ID from URL path
$id = 0;
if (isset($requestParts[1]) && preg_match('/^\d+$/', $requestParts[1])) {
    $id = intval($requestParts[1]);
} else {
    $id = 0;
}

// Validasi halaman yang diizinkan
$validPages = ['home', 'add', 'edit', 'view', '404'];
if (!in_array($page, $validPages)) {
    header('Location: /404');
    exit;
}

// Cek jika ada elemen tambahan di URL yang tidak diinginkan
if (count($requestParts) > 2) {
    header('Location: /404');
    exit;
}

// Route handling with error checking
switch ($page) {
    case 'add':
        if ($id > 0) {
            header('Location: /home');
            exit;
        }
        require_once __DIR__ . "/pages/add.php";
        break;
    case 'edit':
        if ($id <= 0) {
            header('Location: /home');
            exit;
        }
        require_once __DIR__ . "/pages/edit.php";
        break;
    case 'view':
        if ($id <= 0) {
            header('Location: /404');
            exit;
        }
        require_once __DIR__ . "/pages/view.php";
        break;
    case '404':
        require_once __DIR__ . "/pages/404.php";
        break;
    case 'home':
    default:
        require_once __DIR__ . "/pages/home.php";
        break;
}
?>
