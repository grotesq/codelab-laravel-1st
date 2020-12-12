<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signUp(Request $request) {
        $params = $request->only([ 'name', 'email', 'password' ]);
        $params[ 'password' ] = bcrypt( $params[ 'password' ] );
        $user = User::create($params);
        return response()->json($user);
    }

    public function signIn(Request $request) {
        $params = $request->only([ 'email', 'password' ]);
        if( Auth::attempt($params) ) {
            $user = User::where( 'email', $params[ 'email' ] )->first();
            $token = $user->createToken(env('APP_KEY'));
            return response()->json( [
                'user' => $user,
                'token' => $token->plainTextToken,
            ] );
        }
        else {
            return response()->json( ['message' => '로그인 정보를 확인하세요'], 400 );
        }
    }
}
