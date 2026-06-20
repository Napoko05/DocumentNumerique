<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Users\ProfileController;
use App\Http\Controllers\Users\ContactController;
use App\Http\Controllers\Books\BookController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\ProductController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Books\EducationController;
use App\Http\Controllers\DocumentController;

/*
|-------------------------
| PAGES PUBLIQUES
|-------------------------
*/
Route::get('/', fn() => view('index'))->name('home');
Route::get('/about', fn() => view('about'))->name('about');

Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');
/*
|-------------------------
| AUTH GUEST
|-------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:5,1');

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1');
});

/*
|-------------------------
| LOGOUT
|-------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('home');
})->name('logout');

require __DIR__ . '/auth.php';

/*
|-------------------------
| ADMIN
|-------------------------
*/
Route::middleware(['auth:staff', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
   Route::get('/staff/create', [StaffController::class, 'create'])
        ->name('staff.create');

    Route::post('/staff/step1', [StaffController::class, 'step1'])
        ->name('staff.step1');

    Route::get('/staff/step2/view', [StaffController::class, 'step2View'])
        ->name('staff.step2.view');

    Route::post('/staff/store', [StaffController::class, 'store'])
        ->name('staff.store');

    Route::get('/staff', [StaffController::class, 'index'])
        ->name('staff.index');
    // USERS CRUD
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');

    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
});
/*
|-------------------------
| JOURNALIST
|-------------------------
*/
Route::middleware(['auth:staff', 'role:journalist'])->prefix('journalist')->name('journaliste.')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\Users\JournalistController::class, 'dashboard'])->name('dashboard');
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    Route::post('/documents', [App\Http\Controllers\Users\JournalistController::class, 'createDocument'])->name('documents.create');
    Route::get('/users', [App\Http\Controllers\Users\JournalistController::class, 'users'])->name('users.index');
     Route::resource('documents', DocumentController::class);
});

/*
|-------------------------
| USER CONNECTÉ
|-------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post(
    '/users/{user}/activate',
    [UserController::class, 'activate']
)->name('users.activate');
Route::post(
    '/users/{user}/deactivate',
    [UserController::class, 'deactivate']
)->name('users.deactivate');

/*
|-------------------------
| BOOKS
|-------------------------
*/
Route::prefix('books')->name('books.')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::get('/{book}', [BookController::class, 'show'])->name('show');
    Route::post('/{book}/buy', [BookController::class, 'buy'])->middleware('auth')->name('buy');
});

/*
|-------------------------
| SECONDARY
|-------------------------
*/
Route::prefix('secondary')->name('secondary.')->group(function () {
    Route::get('/', [BookController::class, 'secondary'])->name('index');
    Route::get('/general/{cycle}/{classe}', [BookController::class, 'secondaryGeneral'])->name('general');
    Route::get('/technique/{level}', [BookController::class, 'secondaryTechnique'])->name('technique');
});

/*
|-------------------------
| SUPERIOR
|-------------------------
*/
Route::prefix('superior')->name('superior.')->group(function () {
    Route::get('/', [BookController::class, 'superior'])->name('index');
    Route::get('/general/{level}', [BookController::class, 'superiorGeneral'])->name('general');
    Route::get('/technique/{level}', [BookController::class, 'superiorTechnique'])->name('technique');
});

Route::get('/niveau-filiere-superieur', [BookController::class, 'niveauFiliereSuperieur'])->name('niveau_filiere.superieur');


Route::prefix('enseignement')->group(function () {

    Route::get('/', [EducationController::class, 'index'])->name('secondary.technique');

    // ===== ENS =====
    Route::get('/ens/{annee}', [EducationController::class, 'ens'])->name('ens');

    Route::get('/capceg/{matiere}', [EducationController::class, 'capceg'])->name('capceg');

    Route::get('/inspecteur/{type}', [EducationController::class, 'inspecteur'])->name('inspecteur');

    // ===== ENSP =====
    Route::get('/ensp/{niveau}', [EducationController::class, 'ensp'])->name('ensp');

    // ===== IDS =====
    Route::get('/ids/{specialite}', [EducationController::class, 'ids'])->name('ids');

    // ===== ENEP =====
    Route::get('/enep/{niveau}', [EducationController::class, 'enep'])->name('enep');

    // ===== UIT =====
    Route::get('/uit/{filiere}', [EducationController::class, 'uit'])->name('uit');

    // ===== SUPERIEUR TECHNIQUE =====
    Route::get('/superieur-technique/{niveau}', [EducationController::class, 'superieurTechnique'])
        ->name('superieur.technique');
});

