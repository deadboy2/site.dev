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
    <?php if(!empty($article->author)): ?>
        Имя автора: <?= $article->author->name ?><br>
        Фамилия автора: <?= $article->author->surname ?><br>
    <?php endif; ?>
</div>
<?php endforeach; ?>

</body>
</html>