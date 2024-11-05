<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaRequest;
use Illuminate\Http\Request;
use App\Models\Persona;

use Illuminate\Support\Str;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personas = Persona::get();

        return response()->json($personas, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        // return Str::slug($request->nombres);
        // return $validated = $request->validated();

        $persona = new Persona();
        $persona->nombres = $request->nombres;
        $persona->apellidos = $request->apellidos;
        $persona->direccion = $request->direccion;
        $persona->estado = $request->estado;
        $persona->user_id = $request->user_id;
        $persona->save();
        
        return response()->json(["mensaje" => "Persona Creada"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $persona = Persona::findOrFail($id);

        return response()->json($persona, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePersonaRequest $request, string $id)
    {
        $persona = Persona::findOrFail($id);

        $persona->nombres = $request->nombres;
        $persona->apellidos = $request->apellidos;
        $persona->direccion = $request->direccion;
        $persona->estado = $request->estado;
        $persona->user_id = $request->user_id;
        $persona->update();
        return response()->json(["mensaje" => "Persona Actualizada"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();

        return response()->json(["mensaje" => "Persona Eliminada"]);
    }
}
