<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CokoladaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('prikazi-cokolade', [CokoladaController::class, 'prikaziCokolade']);
Route::post('pretraga', [CokoladaController::class, 'pretraziCokolade']);
Route::post('sort', [CokoladaController::class, 'sortirajCokolade']);



Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('sacuvaj-cokoladu', [CokoladaController::class, 'sacuvajCokoladu']);
    Route::get('izmena-cokolade/{id}', [CokoladaController::class, 'izmenaCokolade']);
    Route::post('sacuvaj-izmene/{id}', [CokoladaController::class, 'sacuvajIzmene']);
    Route::delete('obrisi-cokoladu/{id}', [CokoladaController::class, 'obrisiCokoladu']);




    Route::post('logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
