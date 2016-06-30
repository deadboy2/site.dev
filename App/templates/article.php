<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Новость</title>
    <style>
        div.block {
            padding: 10px;
            margin: 10px;
            border: 1px gray solid;
        }
    </style>
</head>
<body>

<?php foreach($article as $art): ?>
<div class="block">
    Заголовок новости: <?= $art->title ?><br>
    Текст новости: <?= $art->text ?><br>
</div>
<?php endforeach; ?>

</body>
</html>