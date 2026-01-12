<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginAuthRequest;
use App\Http\Requests\User\RegisterAuthRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseApiController
{
    //
    /**
     * Cek credentials user.
     * 
     * @param LoginAuthRequest $request
     * @return call fun respondWithToken param $token
    */
    public function login(LoginAuthRequest $request){
        # Validasi formrequest dengan LoginAuthRequest.
        $credentials = $request->validated();
        # Buat dan cek apakah credentials cocok dan ada
        if (!$token = JWTAuth::attempt($credentials)) {
            # Return 401 Unauthorized kalau token tidak dibuat
            return $this->failedUnauthorized(
                message: 'Authentication failed due to invalid credentials',
                errorCode: '1',
                errorMessage: 'Invalid email or password'
            );
        }

        # Auth berhasil dan token dibuat
        return $this->respondWithToken($token);
    }

    /**
     * Create response with token.
     * 
     * @param string $token = get from login
     * @return JsonResponse call fun successLogin param $dataToken, $dataUser
    */
    protected function respondWithToken($token)
    {
        # get current user login
        // $currentUser = JWTAuth::parseToken()->authenticate();
        $currentUser = JWTAuth::setToken($token)->authenticate();
        $currentUser->loadMissing(['roles']);

        # Set waktu kedaluwarsa token (dalam detik)
        $expired = JWTAuth::factory()->getTTL() * 1200;
        $dataToken = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expired,
        ];
        $dataUser = [
            'id' => $currentUser->id,
            'roles' => $currentUser->roles->pluck('slug'),
            'flags' => [
                'has_subscription' => $currentUser->hasValidSubscription(),
                'has_outlet' => $currentUser->hasValidOutlet()
            ]
        ];

        return $this->successLogin(
            dataToken: $dataToken,
            dataUser: $dataUser
        );
    }

    /**
     * Create new user owner.
     * 
     * @param RegisterAuthRequest $request
     * @return JsonResponse call fun successCreateData param $messege, $data
    */
    public function register(RegisterAuthRequest $request)
    {
        # Validate formrequest with RegisterAuthRequest.
        $dataValid = $request->validated();

        # Create data table Users.
        $user = User::create($dataValid);

        # Get Owner Role Id
        $roleOwnerId = Role::where('slug', 'owner')->value('id');
        # Assign role owner
        $user->roles()->sync([$roleOwnerId]);

        # Return json request data $user.
        return $this->successCreateData(
            message: 'User register successfully',
            data: ['id' => $user->id]
        );
    }

    /**
     * Log the user out (Invalidate the token).
     * 
     * @param Request $request
     * @return JsonResponse call fun successLogout
     */
    public function logout(Request $request)
    {
        try {
            # Get token form header request
            // $token = auth()->getToken();
            $token = JWTAuth::parseToken(); 
            
            # Invalidate token
            if ($token) {
                JWTAuth::invalidate($token);
            }
            
            # return response success 200
            return $this->successLogout();

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            # Jika token sudah tidak valid
            return $this->failedUnauthorized(
                message: 'Authentication token invalid',
                errorCode: '3',
                errorMessage: 'Token invalid'
            );
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            # Jika token sudah kadaluarsa sebelum di-logout
            return $this->failedUnauthorized(
                message: 'Authentication token has expired',
                errorCode: '2',
                errorMessage: 'Token expired'
            );
        } catch (\Exception $e) {
            # Penanganan error umum
            return $this->failedInternalServerError(
                message: 'Unexpected error occurred on the server',
                errorCode: '71',
                errorMessage: 'Internal system error'
            );
        }
    }
}
