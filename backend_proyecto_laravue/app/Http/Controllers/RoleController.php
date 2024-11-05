<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = DB::table("roles")->get();

        return response()->json($roles, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|unique:roles"
        ]);

        DB::table("roles")->insert(["nombre" => $request->nombre]);
        return response()->json(["mensaje" => "Rol Creado"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $role = DB::table("roles")->find($id);
        $role = DB::table("roles")->where('id','=',$id)->first();
        if($role){
            return response()->json($role, 200);
        }
        return response()->json(["message" => "el role buscado no existe"], 404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = DB::table("roles")->find($id);
        if($role){

            DB::table("roles")
                ->where('id', $id)
                ->update(["nombre" => $request->nombre]);
        
            return response()->json(["message" => "el role ha sido actualizado"], 200);
        }
          return response()->json(["message" => "el role buscado no existe"], 404);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = DB::table("roles")->where('id', '=', $id)->delete();
        
        return response()->json(["message" => "el role ha sido eliminado"], 200);

    }
}
