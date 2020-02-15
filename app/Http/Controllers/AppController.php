<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function idGenerator($context) {
        return $context.date('dmY').abs( crc32( uniqid() ) );
    }

    public function getAuthUser(Request $request) {
        $apiKey = $request->header('Authorization');
        $user = User::where('api_key', $apiKey)->first();
        if($user){
            return $user;
        } else {
            return null;
        }
    }
}
