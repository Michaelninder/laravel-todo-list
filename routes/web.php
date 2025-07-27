<?php

use App\Livewire\Settings\Appearance as SettingsAppearance;
use App\Livewire\Settings\Password as SettingsPassword;
use App\Livewire\Settings\Profile as SettingsProfile;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\TodoItemController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', SettingsProfile::class)->name('settings.profile');
    Route::get('settings/password', SettingsPassword::class)->name('settings.password');
    Route::get('settings/appearance', SettingsAppearance::class)->name('settings.appearance');

    // Todo
    Route::resource('todo', TodoListController::class);
    Route::resource('todo.items', TodoItemController::class);
});

require __DIR__.'/auth.php';