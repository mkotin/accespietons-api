<?php

namespace App\Http\Controllers;

use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StructureController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index() {
        try {
            $structures = Structure::all();
            return response()->json([
                'success' => true,
                'data' => $structures
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
