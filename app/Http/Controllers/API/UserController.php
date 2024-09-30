<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends BaseController
{
    /**
     * User register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success = [
            'id' => $user->id,
            'token' => $user->createToken('MyApp')->plainTextToken,
            'name' => $user->name
        ];
        return $this->sendResponse($success, 'Usuário registrado com sucesso.');

    }
    /**
     * User login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success = [
                'id' => $user->id,
                'token' => $user->createToken('MyApp')->plainTextToken,
                'name' =>$user->name
            ];
            return $this->sendResponse($success, 'Usuário logado com sucesso.');
        }else{ 
            return $this->sendError('Não Autorizado.', ['error'=>'Não Autorizado']);
        } 
    }
}
