<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/reset-password", [AuthController::class, "funResetPassword"]);
// resetPassword
Route::post("/cambio-password", [AuthController::class, "funCambioPassword"]);
// Auth 
Route::prefix('/v1/auth')->group(function(){
    
    Route::post("/login", [AuthController::class, "funLogin"]);
    Route::post("/register", [AuthController::class, "funRegister"]);


    Route::middleware('auth:sanctum')->group(function(){
        
        Route::get("/profile", [AuthController::class, "funPerfil"]);
        Route::post("/logout", [AuthController::class, "funLogout"]);
    });

});

// rutas categorias con SQL





Route::middleware('auth:sanctum')->group(function(){
    // exportar ecxcel
    Route::get("/producto/excel", [ProductoController::class, "exportarExcel"]);
    Route::post("/user/excel/import", [UserController::class, "importarExcel"]);
    // pdf 
    Route::get("/pedido/{id}/pdf-report", [PedidoController::class, "exportarPedidoPDF"]);
    
    // buscar cliente
    Route::get('/cliente/buscar', [ClienteController::class, "buscarCliente"]);
    // registrar producto con imagen
    
    Route::post('/producto-con-imagen', [ProductoController::class, "guardarProductoConImagen"]);


    // actualizar imagen
    Route::post('/producto/{id}/actualizar-image', [ProductoController::class, "actualizarImagen"]);
    
    Route::get('/categoria/reporte-pdf', [CategoriaController::class, "funReportePDF"]);
    Route::get('/categoria', [CategoriaController::class, "funListar"]);
    Route::post('/categoria', [CategoriaController::class, "funGuardar"]);
    Route::get('/categoria/{id}', [CategoriaController::class, "funMostrar"]);
    Route::put('/categoria/{id}', [CategoriaController::class, "funModificar"]);
    Route::delete('/categoria/{id}', [CategoriaController::class, "funEliminar"]);
    // rutas roles (CRUD resource) con Query Builder
    Route::apiResource("role", RoleController::class);
    // rutas personas
    Route::apiResource("persona", PersonaController::class)->middleware('auth:sanctum');
    // rutas para usuarios
    Route::apiResource("usuario", UserController::class)->middleware('auth:sanctum');
    
    // rutas para productos
    Route::apiResource("producto", ProductoController::class);

    // rutas para pedido
    Route::apiResource("pedido", PedidoController::class);
    // rutas para cliente
    Route::apiResource("cliente", ClienteController::class);
});


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    // return $request;
    $request->fulfill();
    // asignar una fecha y hora de verificación al nuevo usuario
 
    return response()->json(["Verificacion..."]);
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get("/no-autorizado", function (){
    return response()->json(["mensaje" => "Requiere de inicio de sesion"]);
})->name('login');