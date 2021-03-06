<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Личный кабинет</title>


    <!-- Bootstrap -->
    <link rel="stylesheet" href="/App/templates/css/bootstrap.min.css"/>
    <link rel="stylesheet"  href="/App/templates/css/style.css"/>
    <link rel="stylesheet"  href="/App/templates/css/media.css"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="container">
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 main-block">
        <?php foreach ($avatars as $avatar): ?>
            <div class="col-xs-6 col-sm-2 col-sm-push-1 col-md-2 col-md-push-1 col-lg-2 wrap-main">
                <div class="row">
                    <div class="center-block block-avatars">
                        <img class="img-inside" src="<?=$avatar?>" alt="avatar">
                    </div>
                    <div class="center-block block-data">
                        <span><?=$in = array_shift($ini);?></span>
                        <?php $id = array_shift($ids); ?>
                        <a href="https://vk.com/id<?=$id?>" target="_blank">
                            <button class="btn btn-primary btn-responsive">Добавить</button>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 text-right">
            <form action="" method="post">
                <button name="isSelect" type="submit" class="btn btn-primary">Далее</button>
            </form>
            <?php if (isset($error)): ?>
                <p style="color: red"><?=$error?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php include __DIR__ . '/layouts/right-bar.php'?>
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 two">
        <p>twoooo</p>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/App/templates/js/bootstrap.min.js"></script>
<script src="//ulogin.ru/js/ulogin.js"></script>
<script type="text/javascript">

</script>
</body>
</html>