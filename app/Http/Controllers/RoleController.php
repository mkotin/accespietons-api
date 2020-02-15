<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index() {
        try {
            $roles = Role::all();
            return response()->json([
                'success' => true,
                'data' => $roles
            ], 200);
        } catch (\Exception $e){
            Log::error($e);
            return response()->json([
                'success' => true,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }
}
