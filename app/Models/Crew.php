<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    protected $table = 'crew';
    protected $primaryKey = 'pkId';
    public $incrementing = true;
    protected $connection = 'sqlite';
    
    protected $hidden = [
        'password',
    ];

}
