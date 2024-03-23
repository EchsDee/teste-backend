<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PipelineController;
use App\Http\Middleware\JWTMiddleware;
use App\Http\Controllers\CardController;


Route::get('/', function () {
    return view('welcome');
});
//rota formulario de login
Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register-form');
//rota do login
Route::post('/register', [UserController::class, 'register'])->name('register');
//rota de formulario de registro
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login-form');
//rota do post do login
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Rota do redirecionamento do google
Route::get('/login/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('login.google.redirect');
//rota do callback do google para registro e login
Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Rotas autenticadas para CRUD das pipelines e dos cards
Route::middleware(['auth:api'])->group(function () {
    //pipelines
    Route::get('/pipeline-view', [PipelineController::class, 'showView'])->name('pipeline.view');
    Route::post('/pipelines', [PipelineController::class, 'create'])->name('pipeline.create');
    Route::delete('/pipelines/{pipeline}', [PipelineController::class, 'delete'])->name('pipeline.delete'); 
    Route::match(['put', 'patch'], '/pipelines/{id}/update', [PipelineController::class, 'update'])->name('pipeline.update');
    //cards
    Route::post('/cards', [CardController::class, 'store'])->name('cards.store');
    Route::get('/cards/{id}', [CardController::class, 'show'])->name('cards.show');
    Route::put('/cards/{id}', [CardController::class, 'update'])->name('cards.update');
    Route::delete('/cards/{id}', [CardController::class, 'destroy'])->name('cards.destroy');
    Route::post('/move-card/{id}', [CardController::class, 'moveToNextPipeline'])->name('move-card');
    Route::patch('/cards/{id}', [CardController::class, 'update'])->name('cards.update');
});



Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



