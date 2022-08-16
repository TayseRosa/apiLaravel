<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarberController;


Route::get('/ping', function() {
    return ['pong'=>true];
});
// Endpoint de login
Route::post('/auth/login', [AuthController::class, 'login']);//login
Route::post('/auth/logout', [AuthController::class, 'logout']);//consequencia do processo de login
Route::post('/auth/refresh', [AuthController::class, 'refresh']);//consequencia do processo de login
Route::post('/user', [AuthController::class, 'create']);//cadastro de login/usuario.

Route::get('/user', [UserController::class, 'read']);//Informações do Perfil
Route::put('/user', [UserController::class, 'update']);//Atualiza Informações do Perfil.
Route::get('/user/favorites', [UserController::class, 'getFavorites']);//lista de favorito
Route::post('/user/favorite', [UserController::class, 'addFavorite']);//Favoritar
Route::get('/user/appointments', [UserController::class, 'getAppointments']);//armazena os agendamentos

Route::get('/barbers', [BarberController::class, 'list']);//Listar barbeiros
Route::get('/barber/{id}', [BarberController::class, 'one']);//Busca info de 1 barbeiro
Route::post('/barber/{id}/appointment', [BarberController::class, 'setAppointment']);//agendamento para o barbeiro.
Route::get('/search', [BarberController::class, 'search']);//Busca barbeiros
