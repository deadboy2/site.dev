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
                } else {
                    $person->sponsor_uid = 0;
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

                /**
                 * Запрашиваем всех друзей из вк у данного пользователя
                 * и заносим их uid в масив
                 */

                $s = file_get_contents('https://api.vk.com/method/friends.get?user_id=' . $_SESSION['auth'] . '&v=5.52');
                $fri = json_decode($s, true);

                $allFriends = [];

                foreach ($fri as $k) {
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

                $i = 0;
                $user = '';
                $notBannedPersons = [];

                while ($i < 5) {

                    $user = array_shift($notFindPersons);

                    $deactiv = file_get_contents('https://api.vk.com/method/users.get?user_id=' . $user . '&v=5.52');
                    $arrBan = json_decode($deactiv, true);

                    foreach ($arrBan as $item) {
                        if (!isset($item["deactivated"])) {
                            $i++;
                            $notBannedPersons[] = $item;
                        }
                    }
                }

                $arr = [];
                $arrInitials = [];
                
                foreach ($notBannedPersons as $person) {
                    $arr[] = $person[0]["id"];
                    $arrInitials[] = $person[0]["first_name"] . " " . $person[0]["last_name"];
                }

                for($i=0;$i<count($notBannedPersons);$i++) {
                    $_SESSION[$i.'person'] = $notBannedPersons[$i];
                }

                $imp = implode(',', $arr);

                /**
                 * Запрашиваем с вк ихние аватарки
                 */

                $p = file_get_contents('https://api.vk.com/method/users.get?user_ids='.$imp.'&fields=photo_100,is_friend' . '&v=5.52');
                $imgs = json_decode($p, true);

                if (isset($_SESSION["0person"])) {
                    $one = file_get_contents('https://api.vk.com/method/users.getFollowers?user_id='.$_SESSION["0person"][0]["id"].'&v=5.52');
                    $oneRes = json_decode($one, true);
                    $followers1 = $oneRes["response"]["items"];
                    if (in_array($uid, $followers1)) {
                        $_SESSION["one"] = 1;
                    } else {
                        unset($_SESSION["one"]);
                    }
                }
                if (isset($_SESSION["1person"])) {
                    $two = file_get_contents('https://api.vk.com/method/users.getFollowers?user_id='.$_SESSION["1person"][0]["id"].'&v=5.52');
                    $twoRes = json_decode($two, true);
                    $followers2 = $twoRes["response"]["items"];
                    if (in_array($uid, $followers2)) {
                        $_SESSION["two"] = 2;
                    } else {
                        unset($_SESSION["two"]);
                    }
                }
                if (isset($_SESSION["2person"])) {
                    $three = file_get_contents('https://api.vk.com/method/users.getFollowers?user_id='.$_SESSION["2person"][0]["id"].'&v=5.52');
                    $threeRes = json_decode($three, true);
                    $followers3 = $threeRes["response"]["items"];
                    if (in_array($uid, $followers3)) {
                        $_SESSION["three"] = 3;
                    } else {
                        unset($_SESSION["three"]);
                    }
                }
                if (isset($_SESSION["3person"])) {
                    $four = file_get_contents('https://api.vk.com/method/users.getFollowers?user_id='.$_SESSION["3person"][0]["id"].'&v=5.52');
                    $fourRes = json_decode($four, true);
                    $followers4 = $fourRes["response"]["items"];
                    if (in_array($uid, $followers4)) {
                        $_SESSION["four"] = 4;
                    } else {
                        unset($_SESSION["four"]);
                    }
                }
                if (isset($_SESSION["4person"])) {
                    $five = file_get_contents('https://api.vk.com/method/users.getFollowers?user_id='.$_SESSION["4person"][0]["id"].'&v=5.52');
                    $fiveRes = json_decode($five, true);
                    $followers5 = $fiveRes["response"]["items"];
                    if (in_array($uid, $followers5)) {
                        $_SESSION["five"] = 5;
                    } else {
                        unset($_SESSION["five"]);
                    }
                }

                /**
                 * Вытаскиваем их из массива и помещаем в
                 * новый массив изображений
                 */

                $arrImg = [];

                foreach ($imgs as $item) {
                    foreach ($item as $value) {
                        $arrImg[] = $value["photo_100"];
                    }
                }

                /**
                 * Проверка на добавления
                 */


                /**
                 * Подготавливаем массив изображений к
                 * дальнейшей их отрисовке
                 */

                $this->view->avatars = $arrImg;
                $this->view->ids = $arr;
                $this->view->ini = $arrInitials;

                /**
                 *
                 */

                if (isset($_POST["isSelect"])) {
                    if (isset($_SESSION["one"],$_SESSION["two"], $_SESSION["three"], $_SESSION["four"], $_SESSION["five"])) {
                        $a = Person::findAllUid();
                        shuffle($a);
                        $res = array_shift($a);
                        var_dump($res);

                        $id = Person::findByIdOnUid($uid);
                        $isSp = $id->sponsor_uid;

                        var_dump($isSp);

                        $person = new Person();
                        $person->id = $id->id;
                        $person->uid = $uid;
                        $person->is_paid = false;
                        $person->is_add = true;
                        if ($isSp !== "0") {
                        $person->sponsor_uid = $isSp;
                        } else {
                            $person->sponsor_uid = $res->uid;
                        }
                        $person->save();
                        header('Location: http://site.dev/payment');
                    } else {
                        $this->view->error = 'Пожалуйста добавьте всех пользователей';
                    }
                }

                $this->view->display(__DIR__ . '/../templates/cabinet.php');
            } else {
                header('Location: http://site.dev/payment');
            }
        } else {
            header('Location: http://site.dev');
        }
    }
}