<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\apiController;
use App\Http\Controllers\BlogController;


//SUPER ADMIN 
Route::get('/admin/users', [apiController::class, 'index'])->name('superadmin');

//SUPER ADMIN BLOGS
Route::get('/admin/home', [BlogController::class, 'index']);

//REGISTRATION ROUTE
Route::post('/register',  [apiController::class, 'register']);

//LOGIN ROUTE
Route::post('/login', [apiController::class, 'login']);

//LOGOUT ROUTE
Route::post('/logout', [apiController::class, 'logout'])->middleware('auth:sanctum');

//Groupin

Route::group(['middleware'=>['auth:sanctum']],function(){
        //Profile
        Route::get('/profile-user',  [apiController::class, 'profile']);


    });

    Route::get('/userprofile', [apiController::class, 'userdata' ]);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// ROUTE FOR BLOGS
Route::apiResource('/blogs', BlogController::class);


