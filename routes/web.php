<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\Vitrine\VitrineTechniqueController;
use App\Http\Controllers\Vitrine\VitrineSuperieurController;
use App\Http\Controllers\Vitrine\VitrineProfessionnelController;

use App\Http\Controllers\Users\JournalistController;

use App\Http\Controllers\Admin\Secondaire\LevelController;
use App\Http\Controllers\Admin\Secondaire\SubjectController;
use App\Http\Controllers\Admin\Superieur\SubjectController as SuperieurSubjectController;
use App\Http\Controllers\Admin\Superieur\FiliereController;


/*
|--------------------------------------------------------------------------
| PAGES PUBLIQUES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/about', fn() => view('about'))
    ->name('about');


/*
|--------------------------------------------------------------------------
| CONTACT
|--------------------------------------------------------------------------
*/

Route::get('/contact', [ContactController::class, 'showForm'])
    ->name('contact.form');

Route::post('/contact', [ContactController::class, 'submitForm'])
    ->name('contact.submit');


/*
|--------------------------------------------------------------------------
| AUTHENTIFICATION
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // =========================
    // CONNEXION
    // =========================

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1');


    // =========================
    // INSCRIPTION
    // =========================

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'register'])
        ->middleware('throttle:5,1');
});


/*
|--------------------------------------------------------------------------
| DÉCONNEXION
|--------------------------------------------------------------------------
*/

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| UTILISATEUR CONNECTÉ
|--------------------------------------------------------------------------
*/

Route::prefix('journaliste')
    ->name('journaliste.')
    ->middleware(['auth:staff', 'role:journalist'])
    ->controller(JournalistController::class)
    ->group(function () {

        Route::get('/dashboard', 'dashboard')
            ->name('dashboard');

        Route::get('/users', 'users')
            ->name('users');


        Route::get('/documents', 'documents')
            ->name('documents');


        Route::get('/statistiques', 'statistiques')
            ->name('statistiques');


        Route::get('/profil', 'profil')
            ->name('profil');
    });

/*
|--------------------------------------------------------------------------
| ADMINISTRATION
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware([
        'auth:staff',
        'role:admin',
    ])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | STAFF
        |--------------------------------------------------------------------------
        */

        Route::get('/staff', [StaffController::class, 'index'])
            ->name('staff.index');

        Route::get('/staff/create', [StaffController::class, 'create'])
            ->name('staff.create');

        Route::post('/staff/step1', [StaffController::class, 'step1'])
            ->name('staff.step1');

        Route::get('/staff/step2/view', [StaffController::class, 'step2View'])
            ->name('staff.step2.view');

        Route::post('/staff/store', [StaffController::class, 'store'])
            ->name('staff.store');


        /*
        |--------------------------------------------------------------------------
        | UTILISATEURS
        |--------------------------------------------------------------------------
        */

        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');

        Route::get('/users/create', [UserController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [UserController::class, 'store'])
            ->name('users.store');

        Route::get('/users/{user}/edit', [UserController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users/{user}', [UserController::class, 'update'])
            ->name('users.update');

        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->name('users.destroy');

        Route::post('/users/{user}/activate', [UserController::class, 'activate'])
            ->name('users.activate');

        Route::post('/users/{user}/deactivate', [UserController::class, 'deactivate'])
            ->name('users.deactivate');


        Route::get(
            '/staff/journalistes/{journaliste}/edit',
            [StaffController::class, 'edit']
        )->name('staff.journalistes.edit');

        Route::put(
            '/staff/journalistes/{journaliste}',
            [StaffController::class, 'update']
        )->name('staff.journalistes.update');

        Route::put(
            '/staff/journalistes/{journaliste}/password',
            [StaffController::class, 'updatePassword']
        )->name('staff.journalistes.password.update');

        Route::delete(
            '/staff/journalistes/{journaliste}',
            [StaffController::class, 'destroy']
        )->name('staff.journalistes.destroy');
        /*
        |--------------------------------------------------------------------------
        | RÔLES
        |--------------------------------------------------------------------------
        */

        Route::get('/roles', [RoleController::class, 'index'])
            ->name('roles.index');

        Route::get('/roles/create', [RoleController::class, 'create'])
            ->name('roles.create');

        Route::post('/roles', [RoleController::class, 'store'])
            ->name('roles.store');

        Route::post('/roles/edit', [RoleController::class, 'edit'])
            ->name('roles.edit');




        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */

        Route::get('/permissions', [PermissionController::class, 'index'])
            ->name('permissions.index');

        Route::get('/permissions/create', [PermissionController::class, 'create'])
            ->name('permissions.create');

        Route::post('/permissions', [PermissionController::class, 'store'])
            ->name('permissions.store');


        /*
        |--------------------------------------------------------------------------
        | PRODUITS
        |--------------------------------------------------------------------------
        */

        Route::get('/products', [ProductController::class, 'index'])
            ->name('products.index');

        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');

        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');

        Route::put('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');

        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');
    });

/*
|--------------------------------------------------------------------------
| ADMIN — ENSEIGNEMENT SECONDAIRE
|--------------------------------------------------------------------------
*/

Route::prefix('admin/secondaire')
    ->name('admin.secondaire.')
    ->middleware([
        'auth:staff',
        'role:admin',
    ])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | CLASSES
        |--------------------------------------------------------------------------
        */

        Route::resource('classes', LevelController::class);

        Route::patch(
            '/classes/{level}/toggle',
            [LevelController::class, 'toggle']
        )->name('classes.toggle');


        /*
        |--------------------------------------------------------------------------
        | MATIÈRES
        |--------------------------------------------------------------------------
        */

        Route::resource('matieres', SubjectController::class);

        Route::patch(
            '/matieres/{subject}/toggle',
            [SubjectController::class, 'toggle']
        )->name('matieres.toggle');
    });

/*
|--------------------------------------------------------------------------
| ADMIN — ENSEIGNEMENT SUPÉRIEUR
|--------------------------------------------------------------------------
*/

Route::prefix('admin/superieur')
    ->name('admin.superieur.')
    ->middleware([
        'auth:staff',
        'role:admin',
    ])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | FILIÈRES
        |--------------------------------------------------------------------------
        */
        Route::resource('filieres', FiliereController::class);

        Route::patch(
            '/filieres/{filiere}/toggle',
            [FiliereController::class, 'toggle']
        )->name('filieres.toggle');

        /*
        |--------------------------------------------------------------------------
        | MODULES
        |--------------------------------------------------------------------------
        */
        Route::get('/modules', [SuperieurSubjectController::class, 'index'])
            ->name('modules.index');

        Route::get('/modules/create', [SuperieurSubjectController::class, 'create'])
            ->name('modules.create');

        Route::post('/modules', [SuperieurSubjectController::class, 'store'])
            ->name('modules.store');

        Route::get('/modules/{subject}/edit', [SuperieurSubjectController::class, 'edit'])
            ->name('modules.edit');

        Route::put('/modules/{subject}', [SuperieurSubjectController::class, 'update'])
            ->name('modules.update');

        Route::patch(
            '/modules/{subject}/toggle',
            [SuperieurSubjectController::class, 'toggle']
        )->name('modules.toggle');

        Route::delete(
            '/modules/{subject}',
            [SuperieurSubjectController::class, 'destroy']
        )->name('modules.destroy');
    });

/*====================================
      profil personnel journaliste
    */

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profil', [
        JournalistController::class,
        'profile'
    ])->name('profil');

    Route::get('/profil/edit', [
        JournalistController::class,
        'edit'
    ])->name('profile.edit');

    Route::put('/profil', [
        JournalistController::class,
        'updateProfile'
    ])->name('profile.update');

    Route::put('/profil/password', [
        JournalistController::class,
        'updatePassword'
    ])->name('journaliste.password.update');

    Route::delete('/profil', [
        JournalistController::class,
        'destroy'
    ])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ESPACE JOURNALISTE
|--------------------------------------------------------------------------
*/
Route::prefix('journaliste')
    ->name('journaliste.')
    ->middleware([
        'auth:staff',
        'role:journalist',
    ])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | TABLEAU DE BORD
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [JournalistController::class, 'dashboard']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | DOCUMENTS
        |--------------------------------------------------------------------------
        */

        // Liste
        Route::get(
            '/documents',
            [DocumentController::class, 'index']
        )->name('documents.index');

        // Création
        Route::get(
            '/documents/create',
            [DocumentController::class, 'create']
        )->name('documents.create');

        Route::post(
            '/documents',
            [DocumentController::class, 'store']
        )->name('documents.store');


        /*
        |--------------------------------------------------------------------------
        | DOCUMENTS — FILTRES
        |--------------------------------------------------------------------------
        |
        | IMPORTANT :
        | Ces routes doivent être placées AVANT /documents/{document}
        |
        */

        Route::get(
            '/documents/drafts',
            [DocumentController::class, 'drafts']
        )->name('documents.drafts');

        Route::get(
            '/documents/published',
            [DocumentController::class, 'published']
        )->name('documents.published');


        /*
        |--------------------------------------------------------------------------
        | DOCUMENT — CONSULTATION
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/documents/{document}',
            [DocumentController::class, 'show']
        )->name('documents.show');


        /*
        |--------------------------------------------------------------------------
        | DOCUMENT — MODIFICATION
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/documents/{document}/edit',
            [DocumentController::class, 'edit']
        )->name('documents.edit');

        Route::put(
            '/documents/{document}',
            [DocumentController::class, 'update']
        )->name('documents.update');


        /*
        |--------------------------------------------------------------------------
        | DOCUMENT — SUPPRESSION
        |--------------------------------------------------------------------------
        */

        Route::delete(
            '/documents/{document}',
            [DocumentController::class, 'destroy']
        )->name('documents.destroy');

        Route::get(
            '/statistiques',
            [JournalistController::class, 'statistics']
        )->name('statistiques');

        Route::get(
            '/revenus',
            [JournalistController::class, 'revenues']
        )->name('revenus');

        Route::get(
            '/paiements',
            [JournalistController::class, 'payments']
        )->name('paiements');

        /*
|--------------------------------------------------------------------------
| AJAX — FORMATIONS
|--------------------------------------------------------------------------
|
| Catégorie
|    ↓
| Formation
|
*/

        Route::get(
            '/ajax/formations',
            [DocumentController::class, 'getFormationsByCategory']
        )->name('ajax.formations');


        /*
|--------------------------------------------------------------------------
| AJAX — SECONDAIRE
|--------------------------------------------------------------------------
|
| Catégorie
|    ↓
| Formation
|    ↓
| Niveau / Classe
|    ↓
| Matière / Module
|
*/

        Route::get(
            '/ajax/secondary/levels',
            [DocumentController::class, 'getSecondaryLevels']
        )->name('ajax.secondary.levels');


        /*
|--------------------------------------------------------------------------
| AJAX — SUPÉRIEUR
|--------------------------------------------------------------------------
|
| Catégorie
|    ↓
| Domaine académique
|    ↓
| Filière
|    ↓
| Niveau
|    ↓
| Matière / Module
|
*/

        Route::get(
            '/ajax/academic-domains',
            [DocumentController::class, 'getAcademicDomains']
        )->name('ajax.academic-domains');


        Route::get(
            '/ajax/filieres',
            [DocumentController::class, 'getFilieresByDomain']
        )->name('ajax.filieres');


        Route::get(
            '/ajax/higher/levels',
            [DocumentController::class, 'getLevelsByFiliere']
        )->name('ajax.higher.levels');


        /*
|--------------------------------------------------------------------------
| AJAX — PROFESSIONNEL
|--------------------------------------------------------------------------
|
| ENS
| Formation
|    ↓
| Programme
|    ↓
| Spécialité
|    ↓
| Niveau
|    ↓
| Module
|
| IDS
| Formation
|    ↓
| Spécialité
|    ↓
| Niveau
|    ↓
| Module
|
| ENSP
| Formation
|    ↓
| Spécialité
|    ↓
| Niveau
|    ↓
| Module
|
| UIT
| Formation
|    ↓
| Spécialité
|    ↓
| Niveau
|    ↓
| Module
|
| ENEP
| Formation
|    ↓
| Niveau
|    ↓
| Module
|
*/


        /*
|--------------------------------------------------------------------------
| PROFESSIONNEL — FORMATION → NIVEAU
|--------------------------------------------------------------------------
|
| UNIQUEMENT ENEP
|
*/

        Route::get(
            '/ajax/professional/levels',
            [DocumentController::class, 'getProfessionalLevelsByFormation']
        )->name('ajax.professional.levels');


        /*
|--------------------------------------------------------------------------
| PROFESSIONNEL — FORMATION → SPÉCIALITÉ
|--------------------------------------------------------------------------
|
| IDS
| ENSP
| UIT
|
*/

        Route::get(
            '/ajax/specialites-by-formation',
            [DocumentController::class, 'getSpecialitesByFormation']
        )->name('ajax.specialites-by-formation');


        /*
|--------------------------------------------------------------------------
| PROFESSIONNEL — FORMATION → PROGRAMME
|--------------------------------------------------------------------------
|
| UNIQUEMENT ENS
|
*/

        Route::get(
            '/ajax/programs',
            [DocumentController::class, 'getProgramsByFormation']
        )->name('ajax.programs');


        /*
|--------------------------------------------------------------------------
| PROFESSIONNEL — PROGRAMME → SPÉCIALITÉ
|--------------------------------------------------------------------------
|
| UNIQUEMENT ENS
|
*/

        Route::get(
            '/ajax/specialites',
            [DocumentController::class, 'getSpecialitesByProgram']
        )->name('ajax.specialites');


        /*
|--------------------------------------------------------------------------
| PROFESSIONNEL — SPÉCIALITÉ → NIVEAU
|--------------------------------------------------------------------------
|
| ENS
| IDS
| ENSP
| UIT
|
*/

        Route::get(
            '/ajax/specialite/levels',
            [DocumentController::class, 'getLevelsBySpecialite']
        )->name('ajax.specialite.levels');


        /*
|--------------------------------------------------------------------------
| AJAX — MATIÈRES / MODULES
|--------------------------------------------------------------------------
|
| Niveau
|    ↓
| Matière / Module
|
| Commun à :
|
| - Secondaire
| - Supérieur
| - ENS
| - IDS
| - ENSP
| - UIT
| - ENEP
|
*/

        Route::get(
            '/ajax/subjects',
            [DocumentController::class, 'getSubjectsByLevel']
        )->name('ajax.subjects');
    });
/*
|--------------------------------------------------------------------------
| DOCUMENTS PUBLICS
|--------------------------------------------------------------------------
*/
Route::get('/documents', [PublicDocumentController::class, 'index'])
    ->name('documents.index');

Route::get('/documents/{document}', [PublicDocumentController::class, 'show'])
    ->name('documents.show');

Route::get('/documents/{document}/read', [PublicDocumentController::class, 'read'])
    ->name('documents.read');


/*
|--------------------------------------------------------------------------
| PAIEMENTS
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| VITRINE — ENSEIGNEMENT SECONDAIRE GÉNÉRAL
|--------------------------------------------------------------------------
|
| Classe
|    ↓
| Matière
|    ↓
| Type de document
|    ↓
| Documents
|
*/
Route::prefix('secondaire')
    ->name('vitrine.secondaire.')
    ->group(function () {

        Route::get('/', [
            VitrineSecondaireController::class,
            'index'
        ])->name('index');

        Route::get('/{formation:slug}', [
            VitrineSecondaireController::class,
            'formation'
        ])->name('formation');

        Route::get('/{formation:slug}/{niveau:slug}', [
            VitrineSecondaireController::class,
            'niveau'
        ])->name('niveau');

        Route::get('/{formation:slug}/{niveau:slug}/{matiere:slug}', [
            VitrineSecondaireController::class,
            'subject'
        ])->name('subject');

        Route::get('/{formation:slug}/{niveau:slug}/{matiere:slug}/document/{slug}', [
            VitrineSecondaireController::class,
            'document'
        ])->name('document');
    });
    
/*
|--------------------------------------------------------------------------
| SUPÉRIEUR
| Domaine → Formation → Filière → Spécialité → Niveau
| → Module/Matière → Documents → Document
|--------------------------------------------------------------------------
*/
Route::prefix('superieur')
    ->name('vitrine.superieur.')
    ->group(function () {

        Route::get('/', [
            VitrineSuperieurController::class,
            'domaines'
        ])->name('domaines');

        Route::get(
            '/{domaineSlug}/filieres',
            [
                VitrineSuperieurController::class,
                'filieres'
            ]
        )->name('filieres');

        Route::get(
            '/{domaineSlug}/{filiereSlug}/niveaux',
            [
                VitrineSuperieurController::class,
                'niveaux'
            ]
        )->name('niveaux');

        Route::get(
            '/{domaineSlug}/{filiereSlug}/{niveauSlug}/modules',
            [
                VitrineSuperieurController::class,
                'modules'
            ]
        )->name('modules');

        Route::get(
            '/{domaineSlug}/{filiereSlug}/{niveauSlug}/{subjectSlug}/documents',
            [
                VitrineSuperieurController::class,
                'documents'
            ]
        )->name('documents');

        Route::get(
            '/{domaineSlug}/{filiereSlug}/{niveauSlug}/{subjectSlug}/document/{documentSlug}',
            [
                VitrineSuperieurController::class,
                'show'
            ]
        )->name('show');
    });

/*
|--------------------------------------------------------------------------
| VITRINE — ENSEIGNEMENT PROFESSIONNEL
|--------------------------------------------------------------------------
|
| ENEP :
| Formation → Niveau → Module/Matière → Type → Documents
|
| ENSP / IDS / UIT :
| Formation → Spécialité → Niveau → Module/Matière → Type → Documents
|
| ENS :
| Formation → Programme → Spécialité → Niveau → Type → Documents
|
*/
Route::prefix('professionnel')
    ->name('vitrine.professionnel.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | FORMATIONS
        |--------------------------------------------------------------------------

        | Page générale des formations professionnelles
        |
        | /professionnel
        */
        Route::get('/', [
            VitrineProfessionnelController::class,
            'formations'
        ])->name('formations');
        /*
        |--------------------------------------------------------------------------
        | ENEP
        | Formation → Niveau → Module → Type → Documents → Document
        |--------------------------------------------------------------------------
        */
        Route::get('/{formationSlug}/niveaux', [
            VitrineProfessionnelController::class,
            'niveaux'
        ])->name('formation.niveaux');

        Route::get('/{formationSlug}/{niveauSlug}/modules', [
            VitrineProfessionnelController::class,
            'modules'
        ])->name('enep.modules');

        Route::get('/{formationSlug}/{niveauSlug}/module/{moduleSlug}', [
            VitrineProfessionnelController::class,
            'typeDocumentsModule'
        ])->name('enep.type_doc');

        Route::get('/{formationSlug}/{niveauSlug}/module/{moduleSlug}/type/{typeSlug}', [
            VitrineProfessionnelController::class,
            'documentsModule'
        ])->name('enep.documents');


        Route::get(
            '/{formationSlug}/{niveauSlug}/module/{moduleSlug}/type/{typeSlug}/document/{documentSlug}',
            [
                VitrineProfessionnelController::class,
                'showDocumentModule'
            ]
        )->name('enep.show');


        /*
        |--------------------------------------------------------------------------
        | ENSP / IDS / UIT
        | Formation → Spécialité → Niveau → Module → Type → Documents
        |--------------------------------------------------------------------------
        */

        Route::get('/{formationSlug}/specialites', [
            VitrineProfessionnelController::class,
            'specialitesFormation'
        ])->name('specialites');


        Route::get('/{formationSlug}/specialite/{specialiteSlug}/niveaux', [
            VitrineProfessionnelController::class,
            'niveauxSpecialite'
        ])->name('specialite.niveaux');


        Route::get(
            '/{formationSlug}/specialite/{specialiteSlug}/niveau/{niveauSlug}/modules',
            [
                VitrineProfessionnelController::class,
                'modulesSpecialite'
            ]
        )->name('specialite.modules');


        Route::get(
            '/{formationSlug}/specialite/{specialiteSlug}/niveau/{niveauSlug}/module/{moduleSlug}',
            [
                VitrineProfessionnelController::class,
                'typeDocumentsSpecialiteModule'
            ]
        )->name('specialite.type_doc');


        Route::get(
            '/{formationSlug}/specialite/{specialiteSlug}/niveau/{niveauSlug}/module/{moduleSlug}/type/{typeSlug}',
            [
                VitrineProfessionnelController::class,
                'documentsSpecialiteModule'
            ]
        )->name('specialite.documents');


        Route::get(
            '/{formationSlug}/specialite/{specialiteSlug}/niveau/{niveauSlug}/module/{moduleSlug}/type/{typeSlug}/document/{documentSlug}',
            [
                VitrineProfessionnelController::class,
                'showDocumentSpecialiteModule'
            ]
        )->name('specialite.show');


        /*
        |--------------------------------------------------------------------------
        | ENS
        | Formation → Programme → Spécialité → Niveau → Module → Type
        |--------------------------------------------------------------------------
        */

        Route::get('/ens/programmes', [
            VitrineProfessionnelController::class,
            'programmes'
        ])->name('ens.programmes');


        Route::get('/ens/programme/{programmeSlug}/specialites', [
            VitrineProfessionnelController::class,
            'specialites'
        ])->name('ens.specialites');


        Route::get('/ens/programme/{programmeSlug}/specialite/{specialiteSlug}/niveaux', [
            VitrineProfessionnelController::class,
            'niveauxEns'
        ])->name('ens.niveaux');


        Route::get(
            '/ens/programme/{programmeSlug}/specialite/{specialiteSlug}/niveau/{niveauSlug}/modules',
            [
                VitrineProfessionnelController::class,
                'modulesEns'
            ]
        )->name('ens.modules');


        Route::get(
            '/ens/programme/{programmeSlug}/specialite/{specialiteSlug}/niveau/{niveauSlug}/module/{moduleSlug}',
            [
                VitrineProfessionnelController::class,
                'typeDocumentsEnsModule'
            ]
        )->name('ens.type_doc');


        Route::get(
            '/ens/programme/{programmeSlug}/specialite/{specialiteSlug}/niveau/{niveauSlug}/module/{moduleSlug}/type/{typeSlug}',
            [
                VitrineProfessionnelController::class,
                'documentsEnsModule'
            ]
        )->name('ens.documents');


        Route::get(
            '/ens/programme/{programmeSlug}/specialite/{specialiteSlug}/niveau/{niveauSlug}/module/{moduleSlug}/type/{typeSlug}/document/{documentSlug}',
            [
                VitrineProfessionnelController::class,
                'showDocumentEnsModule'
            ]
        )->name('ens.show');
    });
