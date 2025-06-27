<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/get/employee', [EmployeeController::class, 'getEmployee'])->name('get.employee');
    Route::post('/store/employee', [EmployeeController::class, 'storeEmployee'])->name('store.employee');
    Route::get('/edit/employee/{id}', [EmployeeController::class, 'editEmployee'])->name('edit.employee');
    Route::put('/update/employee/{id}', [EmployeeController::class, 'updateEmployee'])->name('update.employee');
    Route::delete('/delete/employee/{id}', [EmployeeController::class, 'deleteEmployee'])->name('delete.employee');

    Route::get('/get/position', [PositionController::class, 'getPosition'])->name('get.position');
    Route::post('/store/position', [PositionController::class, 'storePosition'])->name('store.position');
    Route::get('/edit/position/{id}', [PositionController::class, 'editPosition'])->name('edit.position');
    Route::put('/update/position/{id}', [PositionController::class, 'updatePosition'])->name('update.position');
    Route::delete('/delete/position/{id}', [PositionController::class, 'deletePosition'])->name('delete.position');

    Route::get('/get/roles', [RoleController::class, 'getRoles'])->name('get.roles');

});
