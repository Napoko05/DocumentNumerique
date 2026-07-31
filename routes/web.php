<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Users\ProfileController;
use App\Http\Controllers\Users\ContactController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\ProductController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Documents\DocumentController;
use App\Http\Controllers\Public\PublicDocumentController;
use App\Http\Controllers\Paiements\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Vitrine\VitrineSecondaireController;
use App\Http\Controllers\Vitrine\VitrineSuperieurController;
use App\Http\Controllers\Vitrine\VitrineProfessionnelController;
use App\Http\Controllers\Users\JournalistController;
use App\Http\Controllers\Vitrine\VitrineTechniqueController;


use App\Http\Controllers;

/*
|-------------------------
| PAGES PUBLIQUES
|-------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
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
/**=====================
 * controller de la creation d'un document important
 * =====================
 */

Route::prefix('journaliste')
    ->middleware(['auth:staff', 'role:journalist'])
    ->name('journaliste.')
    ->group(function () {

        Route::get('/documents', [DocumentController::class, 'index'])
            ->name('documents.index');

        Route::get('/documents/create', [DocumentController::class, 'create'])
            ->name('documents.create');

        Route::post('/documents', [DocumentController::class, 'store'])
            ->name('documents.store');

        Route::get('/documents/{document}', [DocumentController::class, 'show'])
            ->name('documents.show');

        Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])
            ->name('documents.edit');

        Route::put('/documents/{document}', [DocumentController::class, 'update'])
            ->name('documents.update');

        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])
            ->name('documents.destroy');
    });
/*
|-------------------------
| JOURNALIST
|-------------------------
*/

Route::prefix('journaliste')
    ->middleware(['auth:staff', 'role:journalist'])
    ->name('journaliste.')
    ->group(function () {

        // Tableau de bord
        Route::get('/dashboard', [JournalistController::class, 'dashboard'])
            ->name('dashboard');

        // Liste des utilisateurs
        Route::get('/users', [JournalistController::class, 'users'])
            ->name('users');
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


/*==============
    Route de documments public
    =====================*/

Route::get('/documents', [PublicDocumentController::class, 'index'])
    ->name('documents.index');

Route::get('/documents/{document}', [PublicDocumentController::class, 'show'])
    ->name('documents.show');

Route::get('/documents/{document}/read', [PublicDocumentController::class, 'read'])
    ->name('documents.read');


Route::middleware('auth')->group(function () {

    Route::get(
        '/payments/{document}',
        [PaymentController::class, 'create']
    )->name('payments.create');

    Route::post(
        '/payments/{document}',
        [PaymentController::class, 'store']
    )->name('payments.store');
});
/*--------------------------------------------------------------------------
| VITRINE SECONDAIRE GENERAL
|--------------------------------------------------------------------------
*/
Route::prefix('secondaire/general')
    ->name('vitrine.secondaire.general.')
    ->controller(VitrineSecondaireController::class)
    ->group(function () {

        Route::get('/', 'classes')
            ->name('classes');

        Route::get('/{classe}', 'matieres')
            ->name('matieres');

        Route::get('/{classe}/{matiere}', 'typeDocuments')
            ->name('type_doc');

        Route::get('/{classe}/{matiere}/{type}', 'documents')
            ->name('documents');
    });
/*
|--------------------------------------------------------------------------
| SECONDAIRE TECHNIQUE
|--------------------------------------------------------------------------
*/
Route::prefix('secondaire/technique')
    ->name('vitrine.secondaire.technique.')
    ->controller(VitrineTechniqueController::class)
    ->group(function () {

        Route::get('/', 'classes')
            ->name('classes');

        Route::get('/{classe}', 'matieres')
            ->name('matieres');

        Route::get('/{classe}/{matiere}', 'typeDocuments')
            ->name('type_doc');

        Route::get('/{classe}/{matiere}/{type}', 'documents')
            ->name('documents');
    });
/*
|--------------------------------------------------------------------------
| VITRINE ENSEIGNEMENT SUPERIEUR
|--------------------------------------------------------------------------
-*/

Route::prefix('superieur')
->name('vitrine.superieur.')
->controller(VitrineSuperieurController::class)
->group(function () {

    Route::get('/', 'domaines')
        ->name('domaines');
    Route::get('/{domaineSlug}', 'filieres')
        ->name('filieres');
    Route::get(
        '/{domaineSlug}/{filiereSlug}',
        'niveaux'
    )->name('niveaux');
    Route::get(
        '/{domaineSlug}/{filiereSlug}/{niveauSlug}',
        'typeDocuments'
    )->name('type_doc');
    Route::get(
        '/{domaineSlug}/{filiereSlug}/{niveauSlug}/{typeSlug}',
        'documents'
    )->name('documents');

});
 /*                                                                         |
| -------------------------------------------------------------------------- |
| PROFESSIONNEL - FORMATIONS SIMPLES                                         |
| -------------------------------------------------------------------------- |
|                                                                            |
| ENSP / ENEP / IDS / ATE                                                    |
|                                                                            |
| Formation                                                                  |
| ↓                                                                          |
| Niveau                                                                     |
| ↓                                                                          |
| Type de document                                                           |
| ↓                                                                          |
| Document                                                                   
|                                                                            
| */

Route::prefix('professionnel')->name('vitrine.professionnel.')->controller(VitrineProfessionnelController::class)->group(function () {

    Route::get(
        '/',
        'formations'
    )->name('formations');
    
    Route::get(
        '/{formationSlug}',
        'niveaux'
    )->name('niveaux');

    Route::get(
        '/{formationSlug}/{niveauSlug}',
        'typeDocuments'
    )->name('type_doc');

    Route::get(
        '/{formationSlug}/{niveauSlug}/{typeSlug}',
        'documents'
    )->name('documents');

});

Route::prefix('ens')->name('vitrine.ens.')->controller(VitrineProfessionnelController::class)->group(function () {

    /*
    |----------------------------------------------------------------------
    | Liste des programmes ENS
    |----------------------------------------------------------------------
    */

    Route::get(
        '/',
        'programmes'
    )->name('programmes');

    Route::get(
        '/{programmeSlug}',
        'specialites'
    )->name('specialites');

    Route::get(
        '/{programmeSlug}/{specialiteSlug}',
        'niveauxEns'
    )->name('niveaux');

    Route::get(
        '/{programmeSlug}/{specialiteSlug}/{niveauSlug}',
        'typeDocumentsEns'
    )->name('type_doc');

    Route::get(
        '/{programmeSlug}/{specialiteSlug}/{niveauSlug}/{typeSlug}',
        'documentsEns')->name('documents');

});