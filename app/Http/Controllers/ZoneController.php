<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends AppController
{
    public function index(Request $request) {
        try {
            $zones = Zone::all();
            return response()->json([
                'success' => true,
                'data' => $zones
            ]);
        } catch (\Exception $e) {
            \DB::rollback();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Error! Try again!'
            ], 500);
        }
    }
}
