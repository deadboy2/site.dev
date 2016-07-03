<?php
require __DIR__ . '/autoload.php';
session_start();

$url = $_SERVER['REQUEST_URI'];
$action = '';
$id = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (isset($_GET['exit'])) {
    unset($_SESSION['auth']);
    header('Location: http://site.dev');
}


$articlesController = new \App\Controllers\Article();
$contactsController = new \App\Controllers\Contacts();
$mainController = new \App\Controllers\Main();
$headerController = new \App\Controllers\Header();
$profileController = new \App\Controllers\Cabinet();
//$errorsController = new \App\Controllers\Error();

switch ($url) {
    case '/':
        $headerController->action('Index');
        $action = 'Index';
        $mainController->action($action);
        break;
    case '/articles':
        $headerController->action('Index');
        $action = 'Articles';
        $articlesController->action($action);
        break;
    case '/article/?id=' . $id:
        $headerController->action('Index');
        $action = 'Article';
        $articlesController->action($action);
        break;
    case '/contacts':
        $headerController->action('Index');
        $action = 'Contacts';
        $contactsController->action($action);
        break;
    case '/profile':
        $headerController->action('Index');
        $action = 'Index';
        $profileController->action($action);
        break;
    default:
        $headerController->action('Index');
        $action = 'Index';
        $mainController->action($action);
}





