<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['create', 'login']]);
    }

    public function create(Request $request)
    {
        $array = ['error' => ''];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            $emailExists = User::where('email', $email)->count();
            if ($emailExists === 0) {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $newUser = new User();
                $newUser->name = $name;
                $newUser->email = $email;
                $newUser->password = $hash;
                $newUser->save();

                $token = Auth::attempt([
                    'email' => $email,
                    'password' => $password
                ]);

                if (!$token) {
                    $array['error'] = 'Ocorreu um erro!';
                    return $array;
                }

                $info = auth()->user();
                $info['avatar'] = url('media/avatars'.$info['avatar']);
                $array['data'] = $info;
                $array['token'] = $token;
            } else {
                $array['error'] = 'E-mail já cadastrado!';
                return $array;
            }
        } else {
            $array['error'] = 'Dados incorretos';
            return $array;
        }

        return $array;
    }
}
