<?php

namespace App\Models;

use App\Model;

class Person extends Model
{
    const TABLE = 'persons';
    
    public $uid;
    public $is_paid;
}