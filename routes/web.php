<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchingSessionController;

Route::get('/', [
    MatchingSessionController::class,
    'create'
])->name('matching.create');


Route::post('/matching/upload', [
    MatchingSessionController::class,
    'upload'
])->name('matching.upload');


Route::post('/matching/select-sheets', [
    MatchingSessionController::class,
    'selectSheets'
])->name('matching.select-sheets');


Route::get('/matching/select-keys', [
    MatchingSessionController::class,
    'selectKeys'
])->name('matching.select-keys');


Route::post('/matching/save-keys', [
    MatchingSessionController::class,
    'saveKeys'
])->name('matching.save-keys');


Route::get('/matching/select-columns', [
    MatchingSessionController::class,
    'selectColumns'
])->name('matching.select-columns');


Route::post('/matching/save-columns', [
    MatchingSessionController::class,
    'saveColumns'
])->name('matching.save-columns');


Route::get('/matching/process', [
    MatchingSessionController::class,
    'process'
])->name('matching.process');


Route::get('/matching/export-excel', [
    MatchingSessionController::class,
    'exportExcel'
])->name('matching.export-excel');