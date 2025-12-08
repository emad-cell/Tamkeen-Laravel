<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::get('/test-mail', function () {
    Mail::raw('Hello from Laravel with Mailpit!', function ($message) {
        $message->to('test@example.com')
            ->subject('Mailpit Test');
    });
    return 'Mail sent!';
});
// require __DIR__.'/settings.php';
// require __DIR__.'/auth.php';
