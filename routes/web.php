<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AffiliatesController;
use App\Http\Controllers\AffiliateTransactionController;


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
    return redirect('/login');
});

Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    Route::get('/afiliados', [HomeController::class, 'abc'])->name('minimumOrders.index');
    
    Route::get('/listar-afiliados', [AffiliatesController::class, 'index']);
    Route::get('/cadastro-afiliados', [AffiliatesController::class, 'create'])->name('affiliates.ShowStore');
    Route::post('/create-afiliados', [AffiliatesController::class, 'store'])->name('affiliates.store');
    Route::get('/afiliado/{email}', [AffiliatesController::class, 'show'])->name('affiliates.show');
    Route::post('/update-afiliado', [AffiliatesController::class, 'update'])->name('affiliates.edit');
    
    Route::get('/saldo/{email}', [AffiliateTransactionController::class, 'show'])->name('transaction.show');
    Route::post('/add-transaction', [AffiliateTransactionController::class, 'addTransaction'])->name('transaction.add');
    
    Route::get('/dashboard', [AffiliateTransactionController::class, 'dashboard'])->name('transaction.dashboard');
});