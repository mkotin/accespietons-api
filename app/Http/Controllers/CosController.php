<?php

namespace App\Http\Controllers;

use App\Models\Cos;
use App\Models\Demande;
use App\models\Inviter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CosController extends AppController
{
    public function store(Request $request)
    {
    	try{
    		$inputs = $request->all();
    		$id = $this->idGenerator('COS');
    		Cos::create($inputs + ['numero_seance' => uniqid(), 'id' => $id]);
    		return response()->json([
                    'success' => true,
                    'message' => 'Succeeded'
            ], 200);
    	} catch(\Exception $e){
    		//DB::rollback();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Error! Try again!'
            ], 500);
    	}
    }

    public function all(Request $request)
    {
    	try{
    		$all = Cos::orderBy('date', 'desc')->get();
    		return response()->json([
                    'success' => true,
                    'data' => $all
            ], 200);
    	} catch(\Exception $e){
    		//DB::rollback();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Error! Try again!'
            ], 500);
    	}
    }

    public function addDemandeToCos(Request $request){
    	try{
    		DB::beginTransaction();
    		$inputs = $request->all();
    		$demande = Demande::where('id', $inputs['demande_id'])->first();
    		$demande->seance_cos_id = $inputs['seance_cos_id'];
    		$demande->save();
    		$id = $this->idGenerator('COS');
    		Inviter::create($inputs + ["participe_structure" => true, "id" => $id]);
    		DB::commit();
    		return response()->json([
                    'success' => true,
                    'message' => 'Succeeded'
            ], 200);
    	} catch(\Exception $e){
    		//DB::rollback();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Error! Try again!'
            ], 500);
    	}
    }
}
