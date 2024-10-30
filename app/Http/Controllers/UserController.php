<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\JwtController;
use App\Http\Requests\UserLogin;

class UserController extends Controller
{
    public function create_user( UserRequest $params){
        $user = Users::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => password_hash($params['password'], PASSWORD_DEFAULT)
        ]);
        
        if($user){
            return jsonResponse("Usuario cadastrado com sucesso",201,[
                'success' => true,
                'erro' => '',
                'token' => '']);
        }

    }
    public function login_user(UserLogin $params){

        $newtoken = new JwtController;

        $user = Users::where('email', $params['email'] )->first();

        if(!$user || !password_verify($params['password'], $user->password)){
            return jsonResponse(
                'Erro'
            , 401, [
            'success' => false,
            'erro' => ' Senha ou Usuario invalido',
            'token' => '']);
        }

        $token = $newtoken->Token($params['email']);
        return jsonResponse(
            'Login efetuado com Sucesso'
        , 200, [
        'success' => true,
        'erro' => '',
        'token' => $token]);

    }
    public function userLogOut(Request $params ){
        $request = request();
        return $request;
       $user = Users::where('email', $request->Auth['email'])->first();
       $user->token = null;
       $user->save();
        // return $user;
    }
    public function getUser(Request $params){
        $User = Users::where('email', $params->Auth['email'])->first();
        return jsonResponse('Dados do Usuario',  200, $User  );
    }
}
