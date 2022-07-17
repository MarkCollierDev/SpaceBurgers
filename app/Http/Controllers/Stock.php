<?php

namespace App\Http\Controllers;

use App\Models\Bun;
use App\Models\Filling;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Stock extends Controller
{

    public function queryBuns(): Response
    {
        $buns = cache()->remember('bunOptions', 60 * 60, function () {
            return Bun::select('description', 'price')->get();
        });
        $result = [
            'items' => $buns
        ];

        return response(json_encode($result), 200)
            ->header('Content-Type', 'text/json');
    }

    public function queryFillings(): Response
    {
        $fillings = cache()->remember('fillingOptions', 60 * 60, function () {
            return Filling::select('description', 'price')->get();
        });
        $result = [
            'items' => $fillings
        ];

        return response(json_encode($result), 200)
            ->header('Content-Type', 'text/json');
    }
}
