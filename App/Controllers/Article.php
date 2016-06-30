<?php

namespace App\Controllers;

use App\TController;

class Article
{
    use TController;
    
    protected function actionArticles()
    {
        $this->view->articles = \App\Models\Article::findAll();
        $this->view->display(__DIR__ . '/../templates/articles.php');
    }

    protected function actionArticle()
    {
        $id = (int)$_GET['id'];
        $res = $this->view->article = \App\Models\Article::findById($id);
        $this->view->display(__DIR__ . '/../templates/article.php');
    }

    protected function actionIndex()
    {
        $this->view->display(__DIR__ . '/../templates/index.php');
    }
}