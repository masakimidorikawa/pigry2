<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\WeightLogController;


Route::get('/register/step1', [MemberController::class, 'create'])->name('register.step1');
Route::post('/register/step1', [MemberController::class, 'store'])->name('register.store');
Route::get('/register/step2', [MemberController::class, 'step2'])->name('register.step2');
Route::post('/register/step2', [MemberController::class, 'step2Store'])->name('register.step2.store');
Route::get('/login', [MemberController::class, 'loginForm'])->name('login');
Route::post('/login', [MemberController::class, 'login'])->name('login.post');
Route::get('/mypage', [MemberController::class, 'mypage'])->name('mypage');
Route::get('/record/create', [RecordController::class, 'kanri'])->name('record.kanri');
Route::post('/record/store', [RecordController::class, 'store'])->name('record.store');
Route::get('/record/{id}/edit', [RecordController::class, 'edit'])->name('record.edit');
Route::put('/record/{id}', [RecordController::class, 'update'])
    ->name('record.update');
Route::delete('/record/{id}', [RecordController::class, 'destroy'])
    ->name('record.destroy');



Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('login');
})->name('logout');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/weight_logs/goal_setting', [MemberController::class, 'editTarget'])
    ->name('target.edit');

Route::post('/weight_logs/goal_setting', [MemberController::class, 'updateTarget'])
    ->name('target.update');

Route::get('/weight_logs/{weightLogId}/edit', [WeightLogController::class, 'edit'])
    ->name('weight_logs.edit');

Route::put('/weight_logs/{weightLogId}', [WeightLogController::class, 'update'])
    ->name('weight_logs.update');

Route::delete('/weight_logs/{weightLogId}', [WeightLogController::class, 'destroy'])
    ->name('weight_logs.destroy');
