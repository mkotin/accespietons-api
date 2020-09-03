<?php

namespace App\Http\Controllers;

use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StructureController extends AppController
{
    public function __construct()
    {
        $this->middleware('auth');
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
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }

    public function store(Request $request) {
        try {
            $input = $request->only(['nom', 'numero_accreditation', 'numero_agrement', 'telephone', 'email', 'siege', 'sigle', 'ifu', 'responsable']);
            $input['id'] = $this->idGenerator('STRUCT');
            $structure = Structure::create($input);
            if($structure) {
                return response()->json([
                    'success' => true,
                    'data' => $structure
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'code' => 0,
                    'message' => 'Error! Try again!'
                ], 400);
            }
        } catch (\Exception $e){
            Log::error($e);
            return response()->json([
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }

    public function update(Request $request) {
        try {
            $this->validate($request, [
                'id' => 'required',
            ]);
            $input = $request->only(['id', 'nom', 'numero_accreditation', 'numero_agrement', 'telephone', 'email', 'siege', 'sigle', 'ifu', 'responsable']);
            $structure = Structure::find($input['id']);
            if(!$structure) {
                return response()->json([
                    'success' => false,
                    'code' => 1,
                ], 404);
            }

            $structure->nom = $input['nom'];
            $structure->numero_accreditation = $input['numero_accreditation'];
            $structure->telephone = $input['telephone'];
            $structure->numero_agrement = $input['numero_agrement'];
            $structure->email = $input['email'];
            $structure->siege = $input['siege'];
            $structure->sigle = $input['sigle'];
            $structure->sigle = $input['sigle'];
            $structure->ifu = $input['ifu'];
            $structure->responsable = $input['responsable'];

            $structure = $structure->save();

            return response()->json([
                'success' => true,
                'data' => $structure,
            ], 200);
        } catch (\Exception $e){
            Log::error($e);
            return response()->json([
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }

    public function delete($id) {
        try {
            $structure = Structure::find($id);
            if(!$structure) {
                return response()->json([
                    'success' => false,
                    'code' => 1,
                    'message' => 'Not found!'
                ], 404);
            }

            $structure->delete();
            return response()->json([
                'success' => true,
            ], 200);
        } catch (\Exception $e){
            Log::error($e);
            return response()->json([
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }
}
