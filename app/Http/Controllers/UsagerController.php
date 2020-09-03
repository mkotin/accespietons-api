<?php

namespace App\Http\Controllers;

use App\Models\Structure;
use App\models\Usager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsagerController extends AppController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getUsagersByStructure($structureId, $status = null)
    {
        try {
            if($status){
                $usagers = Usager::where('structure_id', $structureId)->where('status', $status)->get();
            } else {
                $usagers = Usager::where('structure_id', $structureId)->get();
            }
            return response()->json([
                'success' => true,
                'data' => $usagers
            ], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 500);
        }
    }
}
