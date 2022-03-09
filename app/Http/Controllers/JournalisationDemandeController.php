<?php

namespace App\Http\Controllers;

use App\Models\JournalisationDemande;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JournalisationDemandeController extends AppController
{
    public function store($demandeId, $title, $description, $request)
    {
        try {
            $user = $this->getAuthUser($request);
            $role = Role::where("id", $user->role_id)->first();
            JournalisationDemande::create(
                [
                    "user_id" => $user->id,
                    "demande_id" => $demandeId,
                    "title" => $title,
                    "description" => $user->fname." ".$user->lname." (".$role->role.") ".  $description
                ]
            );
            return true;
        } catch (\Exception $e) {
            Log::error($e);
           return false;
        }
    }

    public function list($demandeId) {
        try {
            $data = JournalisationDemande::where('demande_id', $demandeId)->orderBy('created_at', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Error! Try again!'
            ]);
        }
    }
}
