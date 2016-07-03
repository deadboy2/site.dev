<?php

namespace App\Controllers;

use App\TController;

class Article
{
    use TController;

    protected function actionArticles()
    {
        $this->view->articles = \App\Models\Article::findAllOnUpper();
        $this->view->display(__DIR__ . '/../templates/articles.php');
    }

    protected function actionArticle()
    {

        $id = (int)$_GET['id'];
        $this->view->article = \App\Models\Article::findById($id);
        $this->view->display(__DIR__ . '/../templates/article.php');

    }
}