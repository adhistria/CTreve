<?php
namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
// use Tymon\JWTAuth\PayloadFactory\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'google_id' => 'required|integer',
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors(), 'status' => 0]);
        }

        $user = User::where('google_id', $request->google_id)->first();
        
        if (is_null($user)) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->google_id = $request->google_id;
            $user->save();
        }

        $id = Hash::make($user->id);
        $token = JWTAuth::fromUser($user);

        return response()->json(['token'=> $token, 'user'=> $user]);

    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message'=>'user_not_found','status'=>0], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['message'=>'token_expired','status'=>0], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['message'=>'token_invalid','status'=>0], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            // return response()->json(['token_absent'], $e->getStatusCode());
            return response()->json(['message'=>'token_absent','status'=>0], $e->getStatusCode());

        }
        return response()->json(compact('user'));
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'role_id' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors(), 'status' => 0]);
        }

        $user = User::find(Auth::id());
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json(['status'=>1, 'data'=> $user]);
    }
}