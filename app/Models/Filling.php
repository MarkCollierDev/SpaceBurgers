<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filling extends Model
{
    protected $table = 'fillings';
    protected $primaryKey = 'pkId';
    public $incrementing = true;
    protected $connection = 'sqlite';

    public function Fillings()
    {
        return $this->hasManyThrough(Order::class, OrderFilling::class, 'fillingId', 'pkId', 'orderId', 'pkId');
    }
}
