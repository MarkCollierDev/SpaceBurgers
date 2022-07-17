<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Auth extends Controller
{


    public function login(Request $request): Response
    {

        $requestedUser = ($request->input('user'));
        $crewMember = Crew::findByUserName($requestedUser);
        if ($crewMember['password'] == $request->input('password')) {
            $token = Crew::getToken($crewMember);

            

            $result = ['api_token' => $token, 'message' => 'Log in attempt successful'];
            return response(json_encode($result), 200)
                ->header('Content-Type', 'text/json');
        };
        $result = ['message' => 'Incorrect username or password'];
        return response(json_encode($result), 403)
            ->header('Content-Type', 'text/json');
    }
}
