<?php

namespace App\Http\Controllers;

use App\Models\BadgeType;
use Illuminate\Http\Request;

class BadgeController extends AppController
{
    public function getBadgeTypes(Request $request) {
        try {
            $types = BadgeType::all();
            return response()->json([
                'success' => true,
                'data' => $types
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
