<?php

namespace App\Controllers;

use App\TController;

class Cabinet
{
    use TController;

    protected function actionIndex()
    {
        if (isset($_SESSION['auth'])) {
            $this->view->display(__DIR__ . '/../templates/cabinet.php');
        } else {
            header('Location: http://site.dev');
        }
    }
}