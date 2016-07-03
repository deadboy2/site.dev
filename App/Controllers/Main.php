<?php

namespace App\Controllers;

use App\TController;

class Main
{
    use TController;

    protected function actionIndex()
    {
        $this->view->display(__DIR__ . '/../templates/index.php');
    }
}