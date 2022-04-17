<?php


namespace App\Http\Controllers\Api\V1\Admin\Auth;


use App\EMS\User\User;
use App\Http\Controllers\Api\V1\Admin\AdminBaseController;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends AdminBaseController
{

    /**
     *Login user and create token
     *
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::query()->where('email', $email)->where('status', 1)->first();
            if ($user  && password_verify($password, $user->password)){
                $tokenResult = $user->createToken('Admin Access Token');
                $token = $tokenResult->plainTextToken;
                $data = [
                    'user' => $user,
                    'token' => $token
                ];
                return $this->success($data);
            }
        }catch (\Exception $exception){

        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->revoke();
    }
}
