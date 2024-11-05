<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // select * from users
        $usuarios = User::with('persona', 'roles')->select('id', 'name', 'email')->orderBy('id', 'desc')->get();

        return response()->json($usuarios, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // User::create($request->all());

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        $roles = $request->roles;
        if(count($roles) > 0){
            $usuario->roles()->sync($roles);
        }

        event(new Registered($usuario));

        return response()->json(["mensaje" => "Usuario registrado"], 201);

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
        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->update();

        $roles = $request->roles;
        if(count($roles) > 0){
            $usuario->roles()->sync($roles);
        }

        return response()->json(["mensaje" => "Usuario actualizado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function importarExcel(Request $request){

        $request->validate([
            "file" => "required|mimes:xlsx,xls"
        ]);
        $file = $request->file('file');

        Excel::import(new UserImport, $file);

        return response()->json(["message" => "Excel importado correctamente"]);
    }
    
}
