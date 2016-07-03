<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Новости</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="/App/templates/css/bootstrap.min.css"/>
    <link rel="stylesheet"  href="/App/templates/css/style.css"/>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>


<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-8 col-lg-9">
            <?php foreach($articles as $article): ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="label label-info">Дата публикации:</span><span class="date"> <?= $article->date ?></span></div>
                    <div class="panel-body title-news"><?= $article->title ?></div>
                    <div class="panel-footer"><a href="http://site.dev/article/?id=<?= $article->id ?>">>>>Подробнее</a></div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-4 col-lg-3 block-right">
            <img class="img-responsive center-block" src="http://dummyimage.com/240x400/898a85/fff.png&text=Banner" alt="Banner">
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/App/templates/js/bootstrap.min.js"></script>
<script src="//ulogin.ru/js/ulogin.js"></script>
</body>
</html>


