<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KPIs\TransactionKPIController;
use App\Http\Controllers\KPIs\UserKPIController;
use App\Http\Controllers\KPIs\ProductKPIController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('kpis')->group(function () {

    Route::prefix('transactions')->group(function () {

        Route::get('/', [TransactionKPIController::class, 'index'])
            ->name('transactions.kpi.index');

        Route::get('transaction/volume', [TransactionKPIController::class, 'transactionVolume'])
            ->name('transactions.kpi.volume');


    });

    Route::prefix('/products')->group(function () {

        Route::get('/', [ProductKPIController::class, 'index'])
            ->name('products.kpi.index');

        Route::get('new-products', [ProductKPIController::class, 'totalProducts'])
            ->name('products.kpi.total-products');

    });

    Route::prefix('/users')->group(function () {

        Route::get('/', [UserKPIController::class, 'index'])
            ->name('users.kpi.index');

        Route::get('/all-users', [UserKPIController::class, 'uniqueSellers'])
            ->name('users.kpi.all-users');


    });

});


