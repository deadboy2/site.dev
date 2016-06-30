<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Новости</title>
    <style>
        div.block {
            padding: 10px;
            margin: 10px;
            border: 1px gray solid;
        }
    </style>
</head>
<body>

<?php foreach($articles as $article): ?>
<div class="block">
    Заголовок новости: <?= $article->title ?><br>
    Текст новости: <?= $article->text ?><br>
</div>
<?php endforeach; ?>

</body>
</html>