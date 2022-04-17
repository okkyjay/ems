<?php


namespace App\Http\Controllers\Api\V1\Employee\Auth;


use App\EMS\Employee\Employee;
use App\Http\Controllers\Api\V1\Employee\EmployeeBaseController;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends EmployeeBaseController
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

            $employee = Employee::query()->where('email', $email)->where('status', 1)->first();
            if ($employee  && password_verify($password, $employee->password)){
                $tokenResult = $employee->createToken('Employee Access Token');
                $token = $tokenResult->plainTextToken;
                $data = [
                    'user' => $employee,
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
