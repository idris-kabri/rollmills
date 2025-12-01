<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InteractionController;

Route::get('{platform}/interactions', [InteractionController::class, 'store']);
Route::post('{platform}/interactions', [InteractionController::class, 'store']);