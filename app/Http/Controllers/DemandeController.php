<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Role;
use App\Models\SousDemandeUsager;
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
    protected $journalisationDemandeController;
    public function __construct()
    {
        $this->fakeApiController = new FakeApiController();
        $this->journalisationDemandeController = new JournalisationDemandeController();
    }

    public function storeDemande(Request $request)
    {
        try {
            if ($request->has('usagers') && $request->has('demande')) {
                $inputs = $request->only(['usagers', 'demande']);

                if (!Structure::where('id', $inputs['demande']['structure_id'])->exists()) {
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
                    if (!$badgePrice = $this->fakeApiController->calculateBadgePrice($usager)) {
                        DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => 'Invalid usager at index ' . $key
                        ], 400);
                    }
                    if (isset($usager['id'])) {
                        $newUsager = Usager::find($usager['id']);
                        $newUsager = $this->updateModel($usager, $newUsager, ['']);
                    } else {
                        $newUsager = null;
                    }

                    if (!$newUsager) {
                        $usager['id'] = $this->idGenerator('USAGER');
                        $usager['date_ajout'] = Carbon::now();;
                        $newUsager = Usager::create($usager);
                    }
                    $newUsager->demandes()->attach($demande->id, ['id' => $this->idGenerator('SD'), 'usager_id' => $newUsager->id, 'demande_id' => $demande->id, 'badge_type_id' => $usager['badge_type_id'], 'zone_id' => $usager['zone_id'], 'couttc' => $badgePrice, 'type_acces' => $usager['type_acces'], 'temps_acces' => $usager['temps_acces']]);
                    $demandePrice += $badgePrice;
                    $newUsager->save();
                }
                $demande['montant'] = $demandePrice;

                // Assign to agent
                $agents = User::with(['role' => function ($query) {
                    $query->where('role', 'AGENT SSFA');
                }])->withCount('demandes')
                    ->get()
                    ->filter(function ($item) {
                        if ($item->role) {
                            return true;
                        } else {
                            return false;
                        }
                    });
                $agents = json_decode($agents, true);
                $agents = array_values($agents);

                if (sizeof($agents) > 0) {
                    if (sizeof($agents) > 1) {
                        $agent = $agents[0];
                        foreach ($agents as $value) {
                            if ($agent) {
                                if ($value['demandes_count'] < $agent['demandes_count']) {
                                    $agent = $value;
                                }
                            }
                        }
                    } else {
                        $agent = reset($agents);
                    }
                    if ($agent) {
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
            $user = parent::getAuthUser($request);
            $userRole = Role::where('id', $user->role_id)->first()->role;
            Log::info($userRole);
            $inputs = $request->all();
            switch ($userRole) {
                case 'ADMIN':
                    $demandes = Demande::where($inputs)->with('structure', 'cos')->orderBy("created_at", "asc")->get();
                    break;
                case 'SECRETARIAT DIR. GEN.':
                    $demandes = Demande::where($inputs)->where('niveau_acces', '<=', 3)->with('structure', 'cos')->orderBy("created_at", "asc")->get();
                    break;
                case 'COMMANDANT':
                    $demandes = Demande::where($inputs)->where('niveau_acces', '<=', 2)->with('structure', 'cos')->orderBy("created_at", "asc")->get();
                    break;
                case 'STRUCTURE':
                        $demandes = Demande::where($inputs)->with('structure', 'cos')->orderBy("created_at", "asc")->get();
                        break;
                default:
                    $demandes = Demande::where($inputs)->where('niveau_acces', '<=', 1)->with('structure', 'cos')->orderBy("created_at", "asc")->get();
                    break;
            }
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

    public function getDemande(Request $request)
    {
        try {
            $id = $request->id;
            $user = parent::getAuthUser($request);
            $userRole = Role::where('id', $user->role_id)->first()->role;
            switch ($userRole) {
                case 'ADMIN':
                    $demande = Demande::where('id', $id)->with('structure', 'cos')->with('usagers')->first();
                case 'SECRETARIAT DIR. GEN.':
                    $demande = Demande::where('id', $id)->where('niveau_acces', '<=', 3)->with('structure', 'cos')->with('usagers')->first();
                case 'COMMANDANT':
                    $demande = Demande::where('id', $id)->where('niveau_acces', '<=', 2)->with('structure', 'cos')->with('usagers')->first();
                case 'AGENT SSFA':
                    $demande = Demande::where('id', $id)->where('niveau_acces', '<=', 1)->with('structure', 'cos')->with('usagers')->first();
                default:
                    $demande = Demande::where('id', $id)->with('structure', 'cos')->with('usagers')->first();
            }
            return response()->json([
                'success' => true,
                'data' => $demande
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

    public function affecterDemande(Request $request, $demandeId) {
        try {
            $demande = Demande::where('id', $demandeId)->first();
            $demande->niveau_acces = $demande->niveau_acces - 1;
            $demande->save();
            if($demande->niveau_acces == 2) {
                $this->journalisationDemandeController->store($demandeId, '', 'a affecté la demande au COMMANDANT', $request );
            } else {
                $this->journalisationDemandeController->store($demandeId, '', 'a affecté la demande au SSFA', $request );
            }
            return response()->json([
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Error! Try again!'
            ], 500);
        }
    }

    public function verifierDemande(Request $request, $demandeId) {
        try {
            $demande = Demande::where('id', $demandeId)->first();
            $demande->verifiee = !$demande->verifiee;
            $demande->save();
            if($demande->verifiee == 1) {
                $this->journalisationDemandeController->store($demandeId, '', 'a vérifié la demande', $request );
                return response()->json([
                    'success' => true,
                    'message' => "Demande vérifiée"
                ], 200);
            } else {
                $this->journalisationDemandeController->store($demandeId, '', 'a marqué la demande, non vérifié', $request );
                return response()->json([
                    'success' => true,
                    'message' => "Demande non vérifiée"
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Error! Try again!'
            ]);
        }
    }

    public function verdictDemande(Request $request) {
        try {
            $demandeId = $request->demandeId;
            $nbre = $request->nbre;
            $demande = Demande::find($demandeId);
            $demande->nbre_usagers_accepte = $nbre;
            if($nbre > 0) {
                $demande->statut = "EN_ATTENTE_DU_RAPPORT_STRUCTURE";
            } else {
                $demande->statut = "REJETEE";
            }
            $demande->save();
            if($demande->reglement_demande_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette demande a déjà été payée.'
                ]);
            } else {
                $this->journalisationDemandeController->store($demandeId, '', 'a prononcé un verdict', $request );
                return response()->json([
                    'success' => true,
                    'message' => 'Succès'
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Error! Try again!'
            ]);
        }
    }

    public function submitStructureDemandeReport(Request $request) {
        try {
            DB::beginTransaction();
            $demandeId = $request->demandeId;
            $usagers = $request->usagers;
            $demande = Demande::find($demandeId);
            SousDemandeUsager::where('demande_id', $demandeId)->whereIn("usager_id", $usagers)->update(["autorise" => 1]);
            $montantAcceptee = SousDemandeUsager::where('demande_id', $demandeId)->whereIn("usager_id", $usagers)->sum('couttc');
            $demande->montant_accepte = $montantAcceptee;
            $demande->statut = "VALIDEE";
            $demande->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Succès'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Error! Try again!'
            ]);
        }
    }
}
