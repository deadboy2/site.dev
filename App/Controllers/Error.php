<?php

namespace App\Controllers;

use App\TController;

class Error
{
    use TController;

    protected function actionError()
    {
        $this->view->display(__DIR__ . '/../../404.php');
    }
}