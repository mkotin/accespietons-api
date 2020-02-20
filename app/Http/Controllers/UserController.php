<?php

namespace App\Http\Controllers;

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
    public function getUsers(Request $request) {
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
                'password' => 'required',
                'login' => 'required',
                'role_id' => 'required',
                'structure_id' => 'required',
            ]);

            $fname = $request->fname;
            $lname = $request->lname;
            $email = $request->email;
            $fonction = $request->fonction;
            $login = $request->login;
            $password = $request->password;
            $roleId = $request->role_id;
            $structureId = $request->structure_id;
            $date = Carbon::now();
            $uid = $this->idGenerator('USER');


            if(User::where('email',$email)->exists()){
                return response()->json([
                    'success' => false,
                    'code' => 1,
                    'message' => 'Email already exists!'
                ], 400);
            }

            if(User::where('login',$login)->exists()){
                return response()->json([
                    'success' => false,
                    'code' => 2,
                    'message' => 'Login already exists!'
                ], 400);
            }

            $user = User::create(['id' => $uid, 'fname' => $fname, 'lname' => $lname, 'email' => $email,
                'fonction' => $fonction, 'login' => $login, 'password' => Hash::make($password), 'role_id' => $roleId, 'structure_id' => $structureId, 'register_date' => $date]);
            $verification_code = Str::random(30); //Generate verification code
        DB::table('users_verifications')->insert(['id' => $this->idGenerator('UVERIFIRCATION') ,'user_id' => $uid, 'verification_code' => $verification_code]);
        $subject = "Verification de votre email";
        Mail::send('emails.verify', ['name' => $lname.' '.$fname, 'verification_code' => $verification_code, 'uid' => $uid],
            function ($mail) use ($email, $lname, $fname, $subject) {
                $mail->from(getenv('MAIL_FROM_ADDRESS'), "Port Autonome de Cotonou");
                $mail->to($email, $lname.' '.$fname);
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

    public function authenticate(Request $request)
    {
        try {
            $this->validate($request, [
                'login' => 'required',
                'password' => 'required'
            ]);

            $user = User::where('login', $request->input('login'))->whereNotNull('email_verified_at')->first();
            if(!$user) {
                return response()->json([
                    'success' => false,
                    'code' => 1,
                    'message' => 'User not found'
                ], 404);
            }
            if (Hash::check($request->input('password'), $user->password)) {
                $apikey = base64_encode(Str::random(40));
                User::where('login', $request->input('login'))->update(['api_key' => "$apikey"]);;
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

    public function verifyToken ($token) {
        try {
            if(User::where('api_key', $token)->exists()) {
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
            if($user) {
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

    public function verifyEmail($uid, $token) {
        try {
            if(UserVerification::where('user_id', $uid)->where('verification_code', $token)->exists() && User::where('id', $uid)->whereNull('email_verified_at')->exists()) {
                User::where('id',$uid)->update(['email_verified_at' => Carbon::now()]);
                return redirect()->to(env('WEB_APP_URL').'/login')->send();
            } else {
                return view('404-not-found');
            }
        } catch (\Exception $e) {
            Log::error($e);
            return view('404-not-found');
        }
    }

    public function updateUser(Request $request) {
        try {
            $this->validate($request, [
                'id' => 'required',
            ]);

            $user = User::find($request->id);
            if(!$user) {
                return response()->json([
                    'success' => false,
                    'code' => 1,
                    'message' => 'User not found'
                ], 404);
            }
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->login = $request->login;
            $user->fonction = $request->fonction;
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

    public function deleteUser($id) {
        try {
            $user = User::find($id);
            if(!$user) {
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
