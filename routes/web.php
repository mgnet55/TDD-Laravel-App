<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectInvitationsController;
use App\Http\Controllers\ProjectTasksController;
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
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::group(['middleware' => 'auth'], function () {

    Route::resource('projects', ProjectController::class);
    Route::post('projects/{project}/invitations', [ProjectInvitationsController::class, 'invite'])->name('projects.invite');
    Route::group([], function () {
        Route::resource('projects.tasks', ProjectTasksController::class)->only(['store', 'update', 'destroy']);
    })->scopeBindings();
});
