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

    Route::delete('/backup/schemas/{schema}', [StronkController::class, 'deleteSchemaBackUp']);

    Route::get('/backup/schemas/tables/{schema}/{table}', [StronkController::class, 'createTableOfSchemaBackUp']);

    Route::delete('/backup/schemas/tables/{schema}/{table}', [StronkController::class, 'deleteTableOfSchemaBackUp']);

    Route::get('/backup/full', [StronkController::class, 'createDatabaseBackUp']);

    Route::delete('/backup/full', [StronkController::class, 'deleteDatabaseBackUp']);

    Route::post('/recover/schemas/{schema}', [StronkController::class, 'recoverSchemaBackUp']);

    Route::delete('/recover/schemas/{schema}', [StronkController::class, 'deleteRecoverSchemaBackUp']);
});
