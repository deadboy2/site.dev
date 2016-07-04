<?php

namespace App\Controllers;

use App\Models\Person;
use App\TController;

class Cabinet
{
    use TController;

    protected function actionIndex()
    {
        $uid = $_SESSION['auth'];
        $idd = Person::findByUid($uid);
        if (empty($idd)) {
            $person = new Person();
            $person->uid = $uid;
            $person->save();
        }

        if (isset($_SESSION['auth'])) {
            $s = file_get_contents('https://api.vk.com/method/friends.get?user_id='.$_SESSION['auth'].'&v=5.52');
            $this->view->friends = json_decode($s, true);

            $all = $this->view->friends;
            $allFriends = [];

            foreach ($all as $k) {
                foreach ($k as $item) {
                    foreach ($item as $value) {
                        $allFriends[] = $value;
                    }
                }
            }

            var_dump($allFriends);

            $_SESSION['friends'] = $this->view->friends;
            $this->view->display(__DIR__ . '/../templates/cabinet.php');
        } else {
            header('Location: http://site.dev');
        }
    }
}