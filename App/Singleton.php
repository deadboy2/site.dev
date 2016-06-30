<?php

namespace App;

trait Singleton
{
    protected static $instance;

    protected function __construct()
    {
        
    }

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}