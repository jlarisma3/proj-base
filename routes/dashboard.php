<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function (\Illuminate\Support\Facades\Request $request) {
  var_dump('hello');
})->name('dashboard');
