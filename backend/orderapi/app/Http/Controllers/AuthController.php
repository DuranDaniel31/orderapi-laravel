<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Authcontroller extends Controller
{
    private $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'password_confirmation' => 'required|same:password'
    ];

    private $traductionAttributes = array(
        'name' => 'nombre',
        'password' => 'contraseña'
    );

    /**
     * Display a listing of the resource.
     */
    public function applyValidator(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);
        $data = [];
        if($validator->fails())
        {
            $data = response()->json([
                'errors' => $validator->errors(),
                'data' => $request ->all()
            ],Response::HTTP_BAD_REQUEST);
        }
        return $data;
    }
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            $token = $user->CreateToken('token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ], Response::HTTP_OK);
        }
        else
        {
            return response()->json([
               'message' => 'Credenciales incorrectas'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response()->json([
            'message' => 'session cerrada exitosamente'
        ], Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $data = $this->applyValidator($request);
        if(!empty($data))
        {
            return $data;
        }
        $request['password'] =  bcrypt($request['password']);
        $user = User::create($request->all());
        $response = [
            'message' => 'Registro creado exitosamente',
            'user' => $user

        ];

        return response()->json($response, Response::HTTP_CREATED);
    }
}
