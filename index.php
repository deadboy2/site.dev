<?php
require __DIR__ . '/autoload.php';

$url = $_SERVER['REQUEST_URI'];
$action = '';
$id = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$articlesController = new \App\Controllers\Article();
$errorsController = new \App\Controllers\Error();

switch ($url) {
    case '/':
        $action = 'Index';
        break;
    case '/articles':
        $action = 'Articles';
        break;
    case '/articles/?id=' . $id:
        $action = 'Article';
        break;
    default:
        $action = 'Index';
}

try {
    $articlesController->action($action);
} catch (Exception $e) {
    $errorsController->action('Error');
}




