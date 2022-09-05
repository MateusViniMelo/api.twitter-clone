<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login',"register"]]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $regras = [
            "email" => "required|email",
            "password" => "required|min:8"

        ];

        $feedback = [
            "email.required" => "O Email não pode ser vazio.",
            "email.email" => "Insira um email válido.",
            "password.required" => "A senha não pode ser vazia",
            "password.min" => "A senha precisa conter no mínimo 8 caracteres"
        ];

        $request->validate($regras, $feedback);
        $credentials = $request->all();

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                "message" => "Usuário ou senha inválidos"
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request){
        $regras = [
            "name" => "required|min:8",
            "email" => "required|email|unique:usuarios",
            "password" => "required|min:8",

        ];
        $feedback = [
            "name.required" => "O nome não pode ser vazio",
            "password.required" => "A senha não pode ser vazia",
            "email.required" => "O email não pode ser vazio",
            "name.min" => "O nome deve conter no mínimo 8 caracteres",
            "password.min" => "A senha deve conter no mínimo 8 caracteres",
            "email.email" => "Insira um email válido",
            "email.unique" => "Esse email já está em uso, insira outro"

        ];

        $request->validate($regras,$feedback);

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        return response()->json(
            [
                "status" => "success",
                "message" => "Usuário Cadastrado com sucesso!"
            ],
            200
        );



    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json([
            "user" => auth()->user()
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            
        ]);
    }
}
