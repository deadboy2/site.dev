<?php

namespace App\Controllers;

use App\TController;

class Contacts
{
    use TController;

    protected function actionContacts()
    {
        $this->view->display(__DIR__ . '/../templates/contacts.php');
    }
}