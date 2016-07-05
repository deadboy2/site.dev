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

        $uid = $_SESSION['auth'];
        $idd = Person::findByUid($uid);
        $isAdd = '';

        foreach ($idd as $item) {
            $isAdd = $item->is_add;
        }

        if (empty($idd)) {
            $person = new Person();
            $person->uid = $uid;
            $person->is_paid = false;
            $person->is_add = false;
            $person->save();
        }

        /**
         * Если пользователь авторизован задаем логику
         */

        if (!$isAdd) {
            if (isset($_SESSION['auth'])) {

                /**
                 * Запрашиваем всех друзей из вк у данного пользователя
                 * и заносим их uid в масив
                 */
                
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

                /**
                 * Достаем из бд uid-ы всех зареганых пользователей
                 * и проверяем есть ли эти пользователи в друзьях 
                 * у данного пользователя и отсортировываем их по 2-м 
                 * разным массивам те которые есть в друзьях и тех которых нету
                 */

                $arrP = Person::findAllUid();
                $findPersons = [];
                $notFindPersons = [];

                foreach ($arrP as $person) {
                    foreach ($person as $item) {
                        if (in_array($item, $allFriends)) {
                            $findPersons[] = $item;
                            break;
                        } else {
                            if ($uid == $item) {
                                break;
                            }
                            $notFindPersons[] = $item;
                            break;
                        }
                    }
                }

                /**
                 * Перемешиваем массив пользователей 
                 * которых нет в друзьях у данного пользователя
                 */

                shuffle($notFindPersons);

                /**
                 * И обрезаем массив до 5 рандомных пользователей
                 */

                $fivePersons = array_slice($notFindPersons, 0, 5);

                /**
                 * Заносим их в 5 разных сессий
                 */

                for ($i = 0;$i<count($fivePersons);$i++) {
                    $_SESSION[$i.'friend'] = $fivePersons[$i];
                }

                /**
                 * Запрашиваем с вк ихние аватарки
                 */

                $p = file_get_contents('https://api.vk.com/method/users.get?user_ids='.$_SESSION['0friend'].','.$_SESSION['1friend'].','.$_SESSION['2friend'].','.$_SESSION['3friend'].','.$_SESSION['4friend'].'&fields=photo_100'.'&v=5.52');
                $imgs = json_decode($p, true);

                /**
                 * Вытаскиваем их из массива и помещаем в 
                 * новый массив изображений
                 */

                $arrImg = [];

                foreach ($imgs as $item) {
                    foreach ($item as $value) {
                        $arrImg[] = array_pop($value);
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

                $_SESSION['friends'] = $this->view->friends;
        }

            $this->view->display(__DIR__ . '/../templates/cabinet.php');
        } else {
            header('Location: http://site.dev');
        }
    }
}