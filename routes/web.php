<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/todos', function () {
        return view('todos'); // A Blade file where Livewire component is embedded
    })->name('todos');

    Route::get('/dashboard', function () {
        return view('dashboard'); // A Blade file where Livewire component is embedded
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('profile'); // A Blade file where Livewire component is embedded
    })->name('profile');
});

Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');




require __DIR__.'/auth.php';