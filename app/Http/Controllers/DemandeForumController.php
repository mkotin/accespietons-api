<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\BadgeType;
use App\Models\Demande;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DemandeForumController extends AppController
{
    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages($demandeId)
    {
        try {
            if($demandeId){
                return Message::with('user')->where('demande_id', $demandeId)->orderBy('created_at', 'asc')->get();
            } else {
                return [];
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Echec!'
            ]);
        }
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        try {
            $message = Message::create([
                'message' => $request->input('message'),
                'user_id' => $request->input('user_id'),
                'demande_id' => $request->input('demande_id')
            ]);

            $user = User::find($request->input('user_id'));
            $demande = Demande::find($request->input('demande_id'));

            broadcast(new MessageSent($user, $message, $demande))->toOthers();

            return response()->json([
                'success' => true,
                'message' => 'Message envoyé!'
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Echec!'
            ]);
        }
    }
}
