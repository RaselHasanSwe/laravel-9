<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    public function __invoke(LoginRequest $request) 
    {
        try {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('app_name')->plainTextToken; 
                $success['name'] =  $user->name;
                return $this->sendResponse($success, 'User login successfully.');
            } else { 
                return $this->sendError('Unauthorised.', ['error'=>'Invalid Username or Password'], 401);
            } 
        } catch (\Exception $error) {
            return $this->sendError('Internal Server Error.', ['error'=> $error->getMessage()], $error->getCode());
        }
        
    }
}
