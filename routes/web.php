<?php

use App\Http\Controllers\Line\CallbackController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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
    return view('info.home');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';


// Route::get('/home', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'line', 'namespace' => 'LINE',], function () {
    // Route::post('callback', 'CallbackController@index');
    Route::post('/callback', [CallbackController::class, 'Webhook']);
});
