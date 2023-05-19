<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/register_submit/{role}', [AuthController::class,'register_submit']);
Route::post('/login_submit/{role}', [AuthController::class,'login_submit']);
Route::get('/logout', function(){
    $role = session()->get('ROLE');
    session()->forget('ROLE');
    session()->forget('USERID');
    session()->forget('EMAIL');
    $url = url(''.$role.'-login');
    return redirect($url);
});

Route::group(['middleware'=>['loginauth']], function(){

    Route::get('job/{job_type}', [JobController::class,'list_jobs']);
    Route::group(['middleware'=>['role:client']], function(){
        Route::post('job/apply', [JobController::class,'apply_job']);
        

    });
    Route::group(['middleware'=>['role:agency']], function(){
        
        Route::get('create-new-job', [JobController::class,'create_new_job']);
        Route::post('job/insert', [JobController::class,'insert']);
    });

});
Route::get('/{page?}', [AuthController::class,'index']);