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
        $user = User::where('api_key', $apiKey)->whereNotNull('api_key')->with('role')->with('structure')->first();
        if($user){
            return $user;
        } else {
            return null;
        }
    }

    public function updateModel($array,$model, $exclude = []) {
        $modelAttributes = $model->attributesToArray();
        foreach ($array as $key => $value) {
            if(!in_array($key, $exclude)){
                if(array_key_exists($key, $modelAttributes)) {
                    $model->$key = $value;
                    //array_push($test, $key);
                }
            }
        }
        return $model;
        //return $test;
    }
}
