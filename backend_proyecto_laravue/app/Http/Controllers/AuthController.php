<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as RulesPassword;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function funLogin(Request $request){
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required"       
        ]);

        if (!Auth::attempt(($credenciales))) {
            return response()->json(["message" => "Credenciales Incorrectas"], 401);
        }

        $usuario = $request->user();

        $token = $usuario->createToken("Token Auth")->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "usuario" => $usuario,
        ], 201);
    }

    public function funRegister(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "c_password" => "required|same:password"         
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(["message" => "Usuario registrado con exito"], 201);

    }
    public function funPerfil(){

        $user = Auth::user();
        $user->persona;
        return response()->json($user, 200);

    }
    public function funLogout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json(["message" => "Logout"], 200);
    }
    
    public function funResetPassword(Request $request){
        $request->validate([
            "email" => "required|email"
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if($status == Password::RESET_LINK_SENT){
            return ["status" => __($status)];
        }
    }

    public function funCambioPassword(Request $request){

        $request->validate([
            "email" => "required|email",
            "token" => "required",
            "password" => ["required", "confirmed", RulesPassword::default()]
        ]);

        $status = Password::reset(
            $request->only("email","password","password_confirmation", "token"),
            function (User $user, string $password){
                $user->forceFill([
                    "password" =>Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if($status === Password::PASSWORD_RESET) {
            return response(["message" => "La contraseña se ha modificado"]);
        }

        return response(["message" => __($status)], 500);

        
    }      
    
}
