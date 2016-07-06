<?php

namespace App\Controllers;

use App\Models\Person;
use App\TController;

class Cabinet
{
    use TController;

    protected function actionIndex()
    {
        /**
         * Проверям существует ли данный пользователь в бд,
         * если нет то добавляем его в бд
         */

        if (isset($_SESSION['auth'])) {

            $uid = $_SESSION['auth'];
            $idd = Person::findByUid($uid);
            $isAdd = '';

            foreach ($idd as $item) {
                $isAdd = $item->is_add;
            }

            if (empty($idd)) {
                $person = new Person();
                if (isset($_SESSION['refer'])) {
                    $person->sponsor_uid = $_SESSION['refer'];
                }
                $person->uid = $uid;
                $person->is_paid = false;
                $person->is_add = false;
                $person->save();
            }

            /**
             * Если пользователь авторизован и еще не добавлял 5-ти требуемых пользователей
             * задаем логику
             */

            if (!$isAdd) {
                if (isset($_SESSION['auth'])) {

                    /**
                     * Запрашиваем всех друзей из вк у данного пользователя
                     * и заносим их uid в масив
                     */

                    $s = file_get_contents('https://api.vk.com/method/friends.get?user_id=' . $_SESSION['auth'] . '&v=5.52');
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

                    /**
                     * Достаем из бд uid-ы всех зареганых пользователей
                     * и проверяем есть ли эти пользователи в друзьях
                     * у данного пользователя и отсортировываем их по 2-м
                     * разным массивам те которые есть в друзьях и тех которых нету
                     *
                     * Тут же проверяем и отсеиваем пользователей
                     * удаливших страничку или забаненых
                     */

                    $arrP = Person::findAllUid();
                    $findPersons = [];
                    $notFindPersons = [];
                    $arrBan = [];

                    foreach ($arrP as $person) {
                        $fr = $person->uid;
                        if ($uid == $fr) {
                            continue;
                        }
                        if (in_array($fr, $allFriends)) {
                            $findPersons[] = $fr;
                        } else {
                            $notFindPersons[] = $fr;
                        }
                    }

                    shuffle($notFindPersons);

                    $i = 0;
                    $user = '';
                    $notBannedPersons = [];

                    while ($i < 5) {

                        foreach ($notFindPersons as $person) {
                            $user = $person;
                            var_dump($person);
                            break;
                        }

                        $deactiv = file_get_contents('https://api.vk.com/method/users.get?user_id=' . $user . '&v=5.52');
                        $arrBan = json_decode($deactiv, true);

                        foreach ($arrBan as $item) {
                            foreach ($item as $value) {
                                if (!isset($value["deactivated"])) {
                                    $i++;
                                    $notBannedPersons[] = $value;
                                }
                            }
                        }
                    }

                    var_dump($notBannedPersons);

                    /**
                     * Заносим их в 5 разных сессий
                     */

                    for ($i = 0; $i < count($notBannedPersons); $i++) {
                        $_SESSION[$i . 'friend'] = $notBannedPersons[$i];
                    }

                    /**
                     * Запрашиваем с вк ихние аватарки
                     */

                    $p = file_get_contents('https://api.vk.com/method/users.get?user_ids=' . $_SESSION['0friend'] . ',' . $_SESSION['1friend'] . ',' . $_SESSION['2friend'] . ',' . $_SESSION['3friend'] . ',' . $_SESSION['4friend'] . '&fields=photo_100' . '&v=5.52');
                    $imgs = json_decode($p, true);

                    /**
                     * Вытаскиваем их из массива и помещаем в
                     * новый массив изображений
                     */

                    $arrImg = [];

                    foreach ($imgs as $item) {
                        foreach ($item as $value) {
                            if (isset($value["deactivated"])) {

                            }
                            $arrImg[] = $value["photo_100"];
                        }
                    }

                    /**
                     * Подготавливаем массив изображений к
                     * дальнейшей их отрисовке
                     */

                    $this->view->avatars = $arrImg;

                    /**
                     * это пока не трогаем
                     * это хз чо
                     */

//                $_SESSION['friends'] = $this->view->friends;
                }

                $this->view->display(__DIR__ . '/../templates/cabinet.php');
            }
        } else {
            header('Location: http://site.dev');
        }
    }
}