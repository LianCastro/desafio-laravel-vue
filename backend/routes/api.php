<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EnderecoController;

Route::apiResource('perfis', PerfilController::class);
Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('enderecos', EnderecoController::class);
