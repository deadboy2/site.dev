<?php

namespace App\Controllers;

use App\TController;

class Header
{
    use TController;

    protected function actionIndex()
    {
        if (isset($_POST['token'])) {
            $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
            $this->view->user = json_decode($s, true);
            $_SESSION['auth'] = $this->view->user['identity'];
            $_SESSION['name'] = $this->view->user['first_name'];
            $_SESSION['surname'] = $this->view->user['last_name'];
        }
        $this->view->display(__DIR__ . '/../templates/layouts/header.php');
    }
}