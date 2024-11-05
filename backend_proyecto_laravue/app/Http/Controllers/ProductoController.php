<?php

namespace App\Http\Controllers;

use App\Exports\ProductoExport;
use App\Models\Producto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // /api/producto?page=1&limit=20&q=laptop
        $limit = $request->limit?$request->limit:10;
        $buscar = $request->q?$request->q:'';
        
        if(isset($buscar)){
            $productos = Producto::orderBy('id', 'desc')
                                    ->where('nombre', 'like', "%$buscar%")
                                    ->orWhere('cod_producto', 'like', "%$buscar%")
                                    ->with('categoria')
                                    ->paginate($limit);
            
        }else{
            $productos = Producto::orderBy('id', 'desc')->with('categoria')->paginate($limit);
        }


        return response()->json($productos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->cod_producto = 'COD_'. strtoupper(Str::random(4));
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->estado = true;
        $producto->save();

        return response()->json($producto, 201);
    }

    public function guardarProductoConImagen(Request $request){
        // validando
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
        ]);

        // cargando imagen
        $direccion_image = "";
        if($file = $request->file("imagen")){
            $url_imagen = time()."-".$file->getClientOriginalName();
            $file->move("imagenes/", $url_imagen);
            
            $direccion_image = "imagenes/". $url_imagen;

        }

        // guardar producto con imagen
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->cod_producto = 'COD_'. strtoupper(Str::random(4));
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->estado = true;
        $producto->imagen = $direccion_image;
        $producto->save();

        return response()->json($producto, 201);
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
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
        ]);

        $producto = Producto::findOrFail($id);
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->update();

        return response()->json($producto, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }

    public function actualizarImagen(string $id, Request $request){
        if($file = $request->file("imagen")){
            $url_imagen = time()."-".$file->getClientOriginalName();
            $file->move("imagenes/", $url_imagen);
            
            $direccion_image = "imagenes/". $url_imagen;

            $producto = Producto::find($id);
            $producto->imagen = $direccion_image;
            $producto->update();
            
            return response()->json(["mensaje" => "Imagen Actualizada"], 201);
        }
        return response()->json(["mensaje" => "Se requiere Imagen para actualizar"], 422);
    }

    public function exportarExcel(){
        return Excel::download(new ProductoExport, 'productos.xlsx');
    }
}
