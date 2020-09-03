<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Structure;
use App\Models\User;
use App\models\Usager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DemandeController extends AppController
{
    protected $fakeApiController;
    public function __construct()
    {
        $this->fakeApiController = new FakeApiController();
    }

    public function storeDemande(Request $request) {
        try {
            if($request->has('usagers') && $request->has('demande')) {
                $inputs = $request->only(['usagers', 'demande']);

                if(!Structure::where('id', $inputs['demande']['structure_id'])->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Structure doesn\'t exists !'
                    ], 400);
                }

                // Get static data

                DB::beginTransaction();
                // Create demande
                $inputs['demande']['id'] = $this->idGenerator('DMND');
                $inputs['demande']['date_soumission'] = Carbon::now();
                $inputs['demande']['ref'] = strval(uniqid());
                $demande = Demande::create($inputs['demande']);
                $demandePrice = 0;


                // Create usagers if not exists
                foreach ($inputs['usagers'] as $key => $usager) {
                    //$usager = json_decode($usager);
                    if(!$badgePrice = $this->fakeApiController->calculateBadgePrice($usager)){
                        DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => 'Invalid usager at index '.$key
                        ], 400);
                    }
                    if(isset($usager['id'])) {
                        $newUsager = Usager::find($usager['id']);
                        $newUsager = $this->updateModel($usager, $newUsager, ['']);
                    } else {
                        $newUsager = null;
                    }

                    if(!$newUsager){
                        $usager['id'] = $this->idGenerator('USAGER');
                        $usager['date_ajout'] = Carbon::now();;
                        $newUsager = Usager::create($usager);
                    }
                    $newUsager->demandes()->attach($demande->id, ['id' => $this->idGenerator('SD') , 'usager_id' =>$newUsager->id, 'demande_id' => $demande->id, 'badge_type_id' => $usager['badge_type_id'], 'zone_id' => $usager['zone_id'], 'couttc' => $badgePrice, 'type_acces' => $usager['type_acces'], 'temps_acces' => $usager['temps_acces']]);
                    $demandePrice += $badgePrice;
                    $newUsager->save();
                }
                $demande['montant'] = $demandePrice;

                // Assign to agent
                $agents = User::with(['role' => function($query){
                    $query->where('role', 'AGENT SSFA');
                }])->withCount('demandes')
                ->get()
                ->filter(function($item){
                    if($item->role){
                        return true;
                    } else {
                        return false;
                    }
                });
                $agents = json_decode($agents, true);
                $agents = array_values($agents);
                
                if(sizeof($agents) > 0){
                    if(sizeof($agents) > 1){
                        $agent = $agents[0];
                        foreach ($agents as $value) {
                            if($agent){
                                if($value['demandes_count'] < $agent['demandes_count']){
                                    $agent = $value;
                                }
                            }
                        }
                    } else {
                        $agent = reset($agents);
                    }
                    if($agent){
                        $demande->agent_id = $agent['id'];
                    }
                }

                $demande->save();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Succeeded'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error! Missing required fields: usagers or demandes!'
                ], 500);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Error! Try again!'
            ], 500);
        }
    }

    public function getDemandes(Request $request)
    {
        try {
           $inputs = $request->all();
           $demandes = Demande::where($inputs)->with('structure')->get();
           return response()->json([
            'success' => true,
            'data' => $demandes
        ], 200);   
       } catch (\Exception $e) {
        DB::rollback();
        Log::error($e);
        return response()->json([
            'success' => false,
            'message' => 'Error! Try again!'
        ], 500);
    }
    
}
}
