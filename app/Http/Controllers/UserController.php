<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends AppController
{
    public function getUsers(Request $request)
    {
        try {
            $users = User::with('role')->with('structure')->get();
            return response()->json([
                'success' => true,
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }

    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'email' => 'required|email|max:255|',
                'role_id' => 'required',
                'structure_id' => 'required',
            ]);

            $fname = $request->fname;
            $lname = $request->lname;
            $email = $request->email;
            $fonction = $request->fonction;
            $password = Str::random(10);;
            $roleId = $request->role_id;
            $structureId = $request->structure_id;
            $date = Carbon::now();
            $uid = $this->idGenerator('USER');


            if (User::where('email', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'code' => 1,
                    'message' => 'Email already exists!'
                ], 400);
            }

            if (User::where('structure_id', $structureId)->where('structure_id', '<>', '0')->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Un compte existe déja, pour cette structure!'
                ], 400);
            }


            $user = User::create(['id' => $uid, 'fname' => $fname, 'lname' => $lname, 'email' => $email,
                'fonction' => $fonction, 'password' => Hash::make($password), 'role_id' => $roleId, 'structure_id' => $structureId, 'register_date' => $date]);
            $verification_code = Str::random(30); //Generate verification code
            DB::table('users_verifications')->insert(['id' => $this->idGenerator('VERIFICATION'), 'user_id' => $uid, 'verification_code' => $verification_code]);
            $subject = "Vérification de votre email";
            Mail::send('emails.verify', ['name' => $lname . ' ' . $fname, 'verification_code' => $verification_code, 'uid' => $uid, 'password' => $password],
                function ($mail) use ($email, $lname, $fname, $subject) {
                    $mail->from(getenv('MAIL_FROM_ADDRESS'), "Port Autonome de Cotonou");
                    $mail->to($email, $lname . ' ' . $fname);
                    $mail->subject($subject);
                });
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Thanks for signing up!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }

    public function resetPassword($id)
    {
        try {

            if ($user = User::find($id)) {
                $password = Str::random(10);
                $user->password = Hash::make($password);
                $user->save();
                $subject = "Réinitialisation de mot de passe";
                Mail::send('emails.password-reset', ['name' => $user->lname . ' ' . $user->fname, 'password' => $password],
                    function ($mail) use ($user, $subject) {
                    $mail->from(getenv('MAIL_FROM_ADDRESS'), "Port Autonome de Cotonou");
                    $mail->to($user->email, $user->lname . ' ' . $user->fname);
                    $mail->subject($subject);
                });
                return response()->json(['success' => true], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 1,
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }

    public function authenticate(Request $request)
    {
        Log::info("hello");
        try {
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->input('email'))->whereNotNull('email_verified_at')->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'code' => 1,
                    'message' => 'User not found'
                ], 404);
            }
            if (Hash::check($request->input('password'), $user->password)) {
                $apikey = base64_encode(Str::random(40));
                User::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);;
                return response()->json(['success' => true, 'api_key' => $apikey, 'user' => $user]);
            } else {
                return response()->json(['success' => false, 'code' => 2], 401);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }

    public function verifyToken($token)
    {
        try {
            if (User::where('api_key', $token)->exists()) {
                return response()->json([
                    'success' => true,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                ], 401);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }

    public function getAuth(Request $request)
    {
        try {
            $user = parent::getAuthUser($request);
            if ($user) {
                return response()->json([
                    'success' => true,
                    'data' => $user
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'code' => 1,
                    'message' => 'User not found'
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }

    public function verifyEmail($uid, $token)
    {
        try {
            if (UserVerification::where('user_id', $uid)->where('verification_code', $token)->exists() && User::where('id', $uid)->whereNull('email_verified_at')->exists()) {
                User::where('id', $uid)->update(['email_verified_at' => Carbon::now()]);
                return redirect()->to(env('WEB_APP_URL') . '/login')->send();
            } else {
                return view('404-not-found');
            }
        } catch (\Exception $e) {
            Log::error($e);
            return view('404-not-found');
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $this->validate($request, [
                'id' => 'required',
            ]);

            $user = User::find($request->id);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'code' => 1,
                    'message' => 'User not found'
                ], 404);
            }
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->fonction = $request->fonction;
            $user->password = Hash::make($request->password);

            if ($user->email !== $request->email && User::where('email', $request->email)->exists()) {
                return response()->json([
                    'success' => false,
                    'code' => 2,
                    'message' => 'Email already exists!'
                ], 400);
            }
            $user->email = $request->email;

            $user->role_id = $request->role_id;
            $user->structure_id = $request->structure_id;



            $user->save();
            $user->api_key = base64_encode(Str::random(40));

            return response()->json([
                'success' => true,
                'message' => 'User updated!'
            ], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'code' => 1,
                    'message' => 'User not found'
                ], 404);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted!'
            ], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'code' => 0,
                'message' => 'Error! Try again!'
            ], 400);
        }
    }
}
