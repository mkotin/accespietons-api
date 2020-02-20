<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AppController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function idGenerator($context) {
        return $context.date('dmY').abs( crc32( uniqid() ) );
    }

    public function getAuthUser(Request $request) {
        $apiKey = $request->header('Authorization');
        if(!$apiKey) {
            return null;
        }
        $user = User::where('api_key', $apiKey)->whereNotNull('api_key')->with('role')->first();
        if($user){
            return $user;
        } else {
            return null;
        }
    }
}
