<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Manejar la solicitud de registro
    public function register(RegisterRequest $request)
    {
        // Crear un nuevo usuario con los datos validados por el RegisterRequest
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Generar un token aleatorio para el usuario
        $token = Str::random(60);

        // Guardar el token hasheado en la base de datos
        $user->api_token = hash('sha256', $token);
        $user->save();

        // Devolver el token al cliente para que lo use en solicitudes futuras
        return response()->json(['token' => $token], 201);
    }

    // Manejar la solicitud de inicio de sesión
    public function login(LoginRequest $request)
    {
        // Verificar las credenciales del usuario
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        // Si las credenciales son correctas, generar un nuevo token
        $token = Str::random(60);

        // Guardar el nuevo token hasheado en la base de datos
        $request->user()->api_token = hash('sha256', $token);
        $request->user()->save();

        // Devolver el token al cliente
        return response()->json(['token' => $token]);
    }

    // Manejar la solicitud de cierre de sesión
    public function logout(Request $request)
    {
        // Anular el token en la base de datos
        $request->user()->api_token = null;
        $request->user()->save();

        return response()->json(['message' => 'Logged out successfully']);
    }

    //Realiza una eliminacion sueave de la cuenta(no la elimina del todo)
    public function deleteAccount(Request $request)
{
    // "Eliminar" el usuario (soft delete)
    $request->user()->delete();

    // Como se está "eliminando" la cuenta, también es recomendable cerrar su sesión
    Auth::logout();

    return response()->json(['message' => 'Account deleted successfully']);
}

//Gestiona la restauracion de la cuenta "eliminada"
public function restoreAccount($userId)
{
    $user = User::onlyTrashed()->find($userId);
    if (!$user) {
        return response()->json(['message' => 'Account not found'], 404);
    }

    $user->restore();

    return response()->json(['message' => 'Account restored successfully']);
}
}
