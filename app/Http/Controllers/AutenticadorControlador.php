<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Necesitas importar Str para utilizar str_random
use App\Events\EventNovoRegistro;

class AutenticadorControlador extends Controller
{
    public function registro(Request $request) {
        
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'token' => Str::random(60) // Cambiado de str_random a Str::random
        ]);
        $user->save();
        
        event(new EventNovoRegistro($user));

        return response()->json([
            'res' => 'Usuário criado com sucesso'
        ], 201);
    }

    public function login(Request $request) {
        
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credenciais = [
            'email' => $request->email,
            'password' => $request->password,
            'active' => 1
        ];

        if (!Auth::attempt($credenciais)) {
            return response()->json([
                'res' => 'Acesso negado'
            ], 401);
        }
        
        $user = $request->user();
        $token = $user->createToken('Token de acesso')->accessToken;

        return response()->json([
            'token' => $token
        ], 200);
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'res' => 'Deslogado com sucesso'
        ]);
    }

    public function ativarregistro($id, $token) {
        $user = User::find($id);
        if ($user && $user->token === $token) { // Simplificado para comprobar directamente la igualdad
            $user->active = true;
            $user->token = '';
            $user->save();
            return view('registroativo');
        } else {
            return view('registroerro');
        }
    }
}
