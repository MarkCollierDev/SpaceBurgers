<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'pkId';
    public $incrementing = true;
    protected $connection = 'sqlite';
    public $timestamps = false;

    public $fillable = [
        'bunId',
        'crewId',
        'price',
    ];

    public function crew() {
        return $this->hasOne(Crew::class, 'pkId', 'crewId');
    }

    public function bun() {
        return $this->hasOne(Bun::class, 'pkId', 'bunId');
    }

    public function fillings() {
        return $this->hasManyThrough(Filling::class, OrderFilling::class, 'fillingId', 'pkId','pkId','orderId');
    }


}
