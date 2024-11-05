<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function funListar()
    {

        $categorias = DB::select("select * from categorias");

        return response()->json($categorias, 200 /*, ["Accept" => "Hola"]*/);
    }

    public function funGuardar(Request $request)
    {
        // validar

        // $request->validate([
        //     "nombre" => "required|unique:categorias|min:3|max:30"
        // ]);

        $validator = Validator::make($request->all(), [
            "nombre" => "required|unique:categorias|min:3|max:30"
        ], ["nombre.min" => "El nombre de la categoria debe ser minimo 3 carcteres"]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // guardar
        DB::insert("insert into categorias (nombre, detalle) values (?,?)", [$request->nombre, $request->detalle]);
        // responder
        return response()->json(["mensaje" => "Categoria Creada"], 201);
    }

    public function funMostrar($id)
    {
        $categoria = DB::select("select * from categorias where id = ?", [$id]);
        // responder
        return response()->json($categoria, 200);
    }

    public function funModificar($id, Request $request)
    {
        // modiicar
        DB::update("update categorias set nombre=?, detalle=? where id=?", [$request->nombre, $request->detalle, $id]);
        // responder
        return response()->json(["mensaje" => "Categoria Actualizada"], 201);
    }

    public function funEliminar($id)
    {
        // modiicar
        DB::update("delete from categorias where id=?", [$id]);
        // responder
        return response()->json(["mensaje" => "Categoria Eliminada"], 201);
    }

    public function funReportePDF()
    {
    }
}
