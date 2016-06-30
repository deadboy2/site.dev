<?php

namespace App\Controllers;

use App\View;

class Article
{
//    protected $data = [];
    protected $view;
    
//    public function __set($name, $value)
//    {
//        $this->data[$name] = $value;
//    }
//
//    public function __get($name)
//    {
//        return $this->data[$name];
//    }
    
    function __construct()
    {
        $this->view = new View();
    }

    public function action($action)
    {
        $methodName = 'action' . $action;
        return $this->$methodName();
    }

    protected function actionArticles()
    {
        $this->view->articles = \App\Models\Article::findAll();
        $this->view->display(__DIR__ . '/../templates/articles.php');
    }

    protected function actionArticle()
    {
        $id = (int)$_GET['id'];
        $this->view->article = \App\Models\Article::findById($id);
        $this->view->display(__DIR__ . '/../templates/article.php');
    }

    protected function actionIndex()
    {
        $this->view->display(__DIR__ . '/../templates/index.php');
    }
}