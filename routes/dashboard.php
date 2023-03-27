<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function (\Illuminate\Http\Request $request) {
    return \Inertia\Inertia::render('TestPage');
})->name('dashboard');
