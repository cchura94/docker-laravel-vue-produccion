<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    public function buscarCliente(Request $request){
        $buscar = $request->buscar;

        if(isset($buscar)){
            $cliente = Cliente::where('razon_social', "like", "%$buscar%")
                                ->orWhere('ci_nit', "like", "%$buscar%")
                                ->orWhere('correo', "like", "%$buscar%")
                                ->first();
            
            return response()->json($cliente);

        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::get();
        return response()->json($clientes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $clie = new Cliente();
        $clie->razon_social = $request->razon_social;
        $clie->correo = $request->correo;
        $clie->ci_nit = $request->ci_nit;
        $clie->save();

        return response()->json($clie, 201);
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
}
