<?php
echo '<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
<span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button >
      <a class="navbar-brand" href = "">VkTarget.pro</a>
    </div>
    <div class="collapse navbar-collapse" id = "myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href = "http://site.dev/">Главная</a></li>
        <li><a href = "http://site.dev/articles">Новости</a></li>
        <li><a href = "#">Поддержка</a></li>
        <li><a href = "http://site.dev/contacts">Контакты</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">';
?>
<?php
if (isset($_SESSION['auth'])) {
    $name = $_SESSION['name'];
    $surname = $_SESSION['surname'];
    $photo = $_SESSION['photo'];
    echo '<img src="'.$photo.'" class="img-circle" alt="photo"><li class="dropdown">
  <a href="" class="dropdown-toggle" data-toggle="dropdown">'.$name.' '.$surname.'
  <span class="caret"></span></a>
  <ul class="dropdown-menu">
    <li><a href="http://site.dev/profile">Профиль</a></li>
    <li><a href="#">Партнеры</a></li>
    <li><a href="#">Настройки</a></li>
    <li class="divider"></li>
    <li><a href="http://site.dev/?exit">Выход</a></li>
  </ul>
</li>';
} else {
    echo '<li class="right-vk"><a href="#"><div id="uLogin" data-ulogin="display=small;fields=first_name,last_name,photo,uid;providers=vkontakte;redirect_uri=http%3A%2F%2Fsite.dev/profile"></div></a></li>';
}
echo '</ul>
    </div>
  </div>
</nav>';
?>



