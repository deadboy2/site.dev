<?php

namespace App\Controllers;

use App\TController;

class Person
{
    use TController;

    protected function actionPerson()
    {
        if (isset($_SESSION['auth'])) {
            header('Location: http://site.dev');
        } else {
            $_SESSION['refer'] = (int)$_GET['ref'];
            header('Location: http://site.dev');
        }

    }
}