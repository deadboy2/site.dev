<?php
require __DIR__ . '/autoload.php';

$url = $_SERVER['REQUEST_URI'];
$action = '';
$id = $_GET['id'];

$articlesController = new \App\Controllers\Article();

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

$articlesController->action($action);




