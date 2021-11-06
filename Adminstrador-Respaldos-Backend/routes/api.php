<?php

use App\Http\Controllers\StronkController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::prefix('ADR')->group(function () {
    Route::get('/schemas', [StronkController::class, 'schemas']);

    Route::get('/schemas/tablas/{schema}', [StronkController::class, 'tablasDeSchemas']);

    Route::get('/backup/schemas/{schema}', [StronkController::class, 'createSchemaBackUp']);
});
