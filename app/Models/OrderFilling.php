<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderFilling extends Model
{
    protected $table = 'order_fillings';
    protected $primaryKey = 'pkId';
    public $incrementing = true;
    protected $connection = 'sqlite';
    public $timestamps = false;

    protected $fillable = [
        'orderId',
        'fillingId',
    ];

}
