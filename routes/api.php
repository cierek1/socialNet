<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/search', function () {
//     $queryString = Input::get('queryString');
//     $users = User::where('name', 'like', '%'.$queryString.'%')->get();

    
//     return response()->json($users);
// });