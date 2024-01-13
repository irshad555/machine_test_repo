<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use function response;

/**
 * Description of AuthController
 *
 */ class AuthController extends Controller
{
    
    
    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();
      
        if ($user) {
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password,])) {
                Log::info('User failed to login.', ['email' => $request->email]);
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return $this->checkTwoFactorDetails($user);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }


    public function checkTwoFactorDetails($user)
    {
            $tokenResult = $user->createToken('Access Token');
            $token = $tokenResult->token;
            $token->save();
            Log::info('User logged in.', ['email' => $user->email]);
            return response()->json([
                'id' => $user->id,
                'is_two_factor_auth_enabled' => false,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)
                    ->toDateTimeString()
            ]);
        
    }
    /**
     * signout
     *
     * @return void
     */
    // public function signout()
    // {
    //     auth()->user()->tokens()->delete();
    //     return response()->json([
    //         'message' => 'Logged Out Successfully.'
    //     ]);
    // }
}
