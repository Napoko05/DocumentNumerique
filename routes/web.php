<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\ProfileController;
use App\Http\Controllers\Users\ContactController;
use App\Http\Controllers\Books\BookController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\RoleController;
use App\Http\Controllers\Users\ProductController;
use App\Http\Controllers\Users\AdminController;
use App\Http\Controllers\Users\JournalistController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Pages publiques
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('index'))->name('home');
Route::get('/about', fn() => view('about'))->name('about');

Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Auth / Register (invités uniquement)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('throttle:5,1');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1');
});

/*
|--------------------------------------------------------------------------
| Auth (logout, password, email verification)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
Route::post('/logout', function () {
    Auth::logout();return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboards selon rôle
|--------------------------------------------------------------------------
*/
// Admin Dashboard
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\users\AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);

    // Admin Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });
});

// Journalist Dashboard
Route::middleware(['auth', 'role:journalist'])->prefix('journalist')->name('journalist.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Users\JournalistController::class, 'dashboard'])->name('dashboard');

    // Journalist Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Documents du journaliste
    Route::post('/documents', [App\Http\Controllers\Users\JournalistController::class, 'createDocument'])->name('documents.create');

    // Lecture seule des utilisateurs
    Route::get('/users', [App\Http\Controllers\Users\JournalistController::class, 'users'])->name('users.index');
});

/*
|--------------------------------------------------------------------------
| Pages protégées pour tout utilisateur connecté
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/index', fn() => view('profile.index'))->name('index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Module Livres Numériques (SCIENTIA)
|--------------------------------------------------------------------------
*/
Route::prefix('books')->name('books.')->group(function () {
    // Liste des documents gratuits ou premium
    Route::get('/', [BookController::class, 'index'])->name('index');

    // Lecture d’un document (premium ou gratuit)
    Route::get('/{book}', [BookController::class, 'show'])->name('show');

    // Acheter un document (doit être connecté)
    Route::post('/{book}/buy', [BookController::class, 'buy'])->middleware('auth')->name('buy');

    // Enseignement Secondaire
    Route::prefix('secondary')->name('secondary.')->group(function () {
        Route::get('/', [BookController::class, 'secondary'])->name('index');
        Route::get('/general/{cycle}/{classe}', [BookController::class, 'secondaryGeneral'])->name('general');
        Route::get('/technique/{level}', [BookController::class, 'secondaryTechnique'])->name('technique');
    });

    // Enseignement Supérieur
    Route::prefix('superior')->name('superior.')->group(function () {
        Route::get('/', [BookController::class, 'superior'])->name('index');
        Route::get('/general/{level}', [BookController::class, 'superiorGeneral'])->name('general');
        Route::get('/technique/{level}', [BookController::class, 'superiorTechnique'])->name('technique');
    });
});
