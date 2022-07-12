<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bun extends Model
{
    protected $table = 'buns';
    protected $primaryKey = 'pkId';
    public $incrementing = true;
    protected $connection = 'sqlite';
}
