<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Util\RouteUtil;

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

// Clear all cache:
Route::get('/cache-clear', function () {
    Artisan::call('optimize:clear');
    return 'all cache has been cleared';
});

$DS = DIRECTORY_SEPARATOR;
RouteUtil::getRouteFromController($DS . 'Http' . $DS . 'Controllers' . $DS);
