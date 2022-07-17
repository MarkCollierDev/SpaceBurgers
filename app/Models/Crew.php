<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    protected $table = 'crew';
    protected $primaryKey = 'pkId';
    public $incrementing = true;
    protected $connection = 'sqlite';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'password',
        'api_token'
    ];
    protected function create(array $data)
    {
        return Crew::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(60),
        ]);
    }

    protected static function findByUserName($username)
    {
        return Crew::where('name', $username)->first();
    
    }

    protected static function getToken($crewMember) :string
    {
        if(isset($crewMember['api_token'])) {
            return $crewMember['api_token'];
        }

        var_dump($crewMember['pkId']);

        $token = Str::random(60);
        Crew::where('pkId', $crewMember['pkId'])
        ->first()->update(['api_token' => $token]);

        return $token;
    }

    public function Order() {
        return $this->hasMany(Order::class, 'crewId', 'pkId');
    }
}
