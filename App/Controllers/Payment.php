<?php

namespace App\Controllers;

use App\Models\Person;
use App\TController;

class Payment
{
    use TController;

    protected function actionIndex()
    {
        if (isset($_SESSION['auth'])) {

            

            $this->view->display(__DIR__ . '/../templates/payment.php');
        } else {
            header('Location: http://site.dev');
        }
    }
}