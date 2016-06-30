<?php

namespace App\Models;


use App\Model;

class Article extends Model
{
    const TABLE = 'articles';

    public $title;
    public $text;
}