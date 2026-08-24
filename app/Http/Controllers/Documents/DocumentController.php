<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\AcademicDomain;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Filiere;
use App\Models\Formation;
use App\Models\Level;
use App\Models\Program;
use App\Models\Specialite;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\TeachingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:staff',
            'role:journalist',
        ]);
    }

    private function staff()
    {
        return Auth::guard('staff')->user();
    }

    private function myDocuments()
    {
        return Document::query()
            ->where('staff_id', $this->staff()->id);
    }

    public function index()
    {
        $documents = $this->myDocuments()
            ->with([
                'staff',
                'formation',
                'filiere',
                'program',
                'specialite',
                'level',
                'subject',
                'documentType',
            ])
            ->latest()
            ->paginate(10);

        return view(
            'Documents.index',
            compact('documents')
        );
    }

    public function create()
    {
        $categories = TeachingCategory::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $formations = Formation::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $filieres = Filiere::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $specialites = Specialite::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $levels = Level::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $subjects = Subject::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $documentTypes = DocumentType::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $tags = Tag::query()
            ->orderBy('name')
            ->get();

        return view(
            'Documents.create',
            compact(
                'categories',
                'formations',
                'filieres',
                'specialites',
                'levels',
                'subjects',
                'documentTypes',
                'tags'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    | CATÉGORIE → FORMATIONS
    |--------------------------------------------------------------------------
    */

    public function getFormationsByCategory(Request $request)
    {
        $categorySlug = trim(
            (string)$request->query('category')
        );

        if ($categorySlug === '') {
            return response()->json([]);
        }

        $category = TeachingCategory::query()
            ->where('slug', $categorySlug)
            ->where('is_active', true)
            ->first();

        if (!$category) {
            return response()->json([]);
        }

        $formations = Formation::query()
            ->where(
                'teaching_category_id',
                $category->id
            )
            ->where('is_active', true)
            ->orderBy('position')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'slug',
            ]);

        return response()->json($formations);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    | SECONDAIRE : FORMATION → NIVEAUX
    |--------------------------------------------------------------------------
    */

    public function getSecondaryLevels(Request $request)
    {
        $formationId = $request->query('formation_id');

        if (
            !is_numeric($formationId) ||
            (int) $formationId <= 0
        ) {
            return response()->json([]);
        }

        $formation = Formation::query()
            ->whereKey((int) $formationId)
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'secondaire')
                    ->where('is_active', true);
            })
            ->first();

        if (!$formation) {
            return response()->json([]);
        }

        $levels = Level::query()
            ->where('formation_id', $formation->id)
            ->whereNull('filiere_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        return response()->json($levels);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    | SUPÉRIEUR : CATÉGORIE → DOMAINES ACADÉMIQUES
    |--------------------------------------------------------------------------
    */

    public function getAcademicDomains(Request $request)
    {
        $categorySlug = trim(
            (string)$request->query('category')
        );

        if ($categorySlug === '') {
            return response()->json([]);
        }

        $category = TeachingCategory::query()
            ->where('slug', $categorySlug)
            ->where('is_active', true)
            ->first();

        if (!$category) {
            return response()->json([]);
        }

        $domains = DB::table('academic_domains')
            ->where('is_active', true)
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'slug',
            ]);

        return response()->json($domains);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    | SUPÉRIEUR : DOMAINE → FILIÈRES
    |--------------------------------------------------------------------------
    */

    public function getFilieresByDomain(Request $request)
    {
        $domainId = $request->query(
            'academic_domain_id'
        );

        if (
            !is_numeric($domainId) ||
            (int)$domainId <= 0
        ) {
            return response()->json([]);
        }

        $domainExists = DB::table('academic_domains')
            ->where('id', $domainId)
            ->where('is_active', true)
            ->exists();

        if (!$domainExists) {
            return response()->json([]);
        }

        $filieres = Filiere::query()
            ->where(
                'academic_domain_id',
                $domainId
            )
            ->where('is_active', true)
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'slug',
            ]);

        return response()->json($filieres);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    | SUPÉRIEUR : FILIÈRE → NIVEAUX
    |--------------------------------------------------------------------------
    */

    public function getLevelsByFiliere(Request $request)
    {
        $filiereId = $request->query('filiere_id');

        if (
            !is_numeric($filiereId) ||
            (int) $filiereId <= 0
        ) {
            return response()->json([]);
        }

        $filiere = Filiere::query()
            ->whereKey((int) $filiereId)
            ->where('is_active', true)
            ->whereHas('academicDomain', function ($query) {
                $query->where('is_active', true);
            })
            ->first();

        if (!$filiere) {
            return response()->json([]);
        }

        $levels = Level::query()
            ->where('filiere_id', $filiere->id)
            ->whereNull('formation_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        return response()->json($levels);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    | PROFESSIONNEL : FORMATION → PROGRAMMES
    |--------------------------------------------------------------------------
    |
    | UNIQUEMENT ENS
    |
    | ENS
    | ↓
    | Programme
    | ↓
    | Spécialité
    | ↓
    | Niveau
    | ↓
    | Module
    |
    */

    public function getProgramsByFormation(Request $request)
    {
        $formationId = $request->query('formation_id');

        if (
            !is_numeric($formationId) ||
            (int)$formationId <= 0
        ) {
            return response()->json([]);
        }

        $formation = Formation::query()
            ->where('id', (int)$formationId)
            ->where('is_active', true)
            ->first();

        if (!$formation) {
            return response()->json([]);
        }

        if ($formation->slug !== 'ens') {
            return response()->json([]);
        }

        $programs = Program::query()
            ->where(
                'formation_id',
                $formation->id
            )
            ->where('is_active', true)
            ->orderBy('position')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'slug',
            ]);

        return response()->json($programs);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    | PROFESSIONNEL : PROGRAMME → SPÉCIALITÉS
    |--------------------------------------------------------------------------
    |
    | UNIQUEMENT ENS
    |
    */

    public function getSpecialitesByProgram(Request $request)
    {
        $programId = $request->query('program_id');

        if (
            !is_numeric($programId) ||
            (int)$programId <= 0
        ) {
            return response()->json([]);
        }

        $program = Program::query()
            ->where('id', (int)$programId)
            ->where('is_active', true)
            ->first();

        if (!$program) {
            return response()->json([]);
        }

        $specialites = Specialite::query()
            ->where(
                'program_id',
                $program->id
            )
            ->where('is_active', true)
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'slug',
            ]);

        return response()->json($specialites);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    | PROFESSIONNEL : FORMATION → SPÉCIALITÉS
    |--------------------------------------------------------------------------
    |
    | IDS
    | UIT
    |
    | IDS
    | ↓
    | Spécialité
    | ↓
    | Niveau
    | ↓
    | Module
    |
    */

    public function getSpecialitesByFormation(Request $request)
    {
        $formationId = $request->query('formation_id');

        if (
            !is_numeric($formationId) ||
            (int)$formationId <= 0
        ) {
            return response()->json([]);
        }

        $formation = Formation::query()
            ->where('id', (int)$formationId)
            ->where('is_active', true)
            ->first();

        if (!$formation) {
            return response()->json([]);
        }

        if (!in_array(
            $formation->slug,
            ['ids', 'uit'],
            true
        )) {
            return response()->json([]);
        }

        $specialites = Specialite::query()
            ->where(
                'formation_id',
                $formation->id
            )
            ->where('is_active', true)
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'slug',
            ]);

        return response()->json($specialites);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    | PROFESSIONNEL : FORMATION → NIVEAUX
    |--------------------------------------------------------------------------
    |
    | ENSP
    | ENEP
    | ATE
    |
    | Formation
    | ↓
    | Niveau
    | ↓
    | Module
    |
    */

    public function getProfessionalLevelsByFormation(Request $request)
    {
        $formationId = $request->query('formation_id');

        if (
            !is_numeric($formationId) ||
            (int) $formationId <= 0
        ) {
            return response()->json([]);
        }

        $formation = Formation::query()
            ->whereKey((int) $formationId)
            ->where('is_active', true)
            ->whereIn('slug', [
                'ensp',
                'enep',
                'ate',
            ])
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->first();

        if (!$formation) {
            return response()->json([]);
        }

        $levels = Level::query()
            ->where('formation_id', $formation->id)
            ->whereNull('filiere_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        return response()->json($levels);
    }
    /*
    |--------------------------------------------------------------------------
    | AJAX
    | PROFESSIONNEL : SPÉCIALITÉ → NIVEAUX
    |--------------------------------------------------------------------------
    |
    | ENS
    | IDS
    | UIT
    |
    */

    public function getLevelsBySpecialite(Request $request)
    {
        $specialiteId = $request->query('specialite_id');

        if (
            !is_numeric($specialiteId) ||
            (int) $specialiteId <= 0
        ) {
            return response()->json([]);
        }

        $specialite = Specialite::query()
            ->whereKey((int) $specialiteId)
            ->where('is_active', true)
            ->where(function ($query) {

                // IDS / UIT
                $query->whereHas('formation', function ($formation) {
                    $formation
                        ->where('is_active', true)
                        ->whereIn('slug', [
                            'ids',
                            'uit',
                        ])
                        ->whereHas('teachingCategory', function ($category) {
                            $category
                                ->where('slug', 'professionnel')
                                ->where('is_active', true);
                        });
                })

                    // ENS
                    ->orWhereHas('program.formation', function ($formation) {
                        $formation
                            ->where('is_active', true)
                            ->where('slug', 'ens')
                            ->whereHas('teachingCategory', function ($category) {
                                $category
                                    ->where('slug', 'professionnel')
                                    ->where('is_active', true);
                            });
                    });
            })
            ->first();

        if (!$specialite) {
            return response()->json([]);
        }

        $levels = Level::query()
            ->where('specialite_id', $specialite->id)
            ->whereNull('formation_id')
            ->whereNull('filiere_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        return response()->json($levels);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    | NIVEAU → MATIÈRES / MODULES
    |--------------------------------------------------------------------------
    */

    public function getSubjectsByLevel(Request $request)
    {
        $levelId = $request->query('level_id');

        if (
            !is_numeric($levelId) ||
            (int)$levelId <= 0
        ) {
            return response()->json([]);
        }

        $levelExists = Level::query()
            ->where('id', $levelId)
            ->where('is_active', true)
            ->exists();

        if (!$levelExists) {
            return response()->json([]);
        }

        $subjects = Subject::query()
            ->where(
                'level_id',
                $levelId
            )
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'slug',
            ]);

        return response()->json($subjects);
    }

    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER LE DOCUMENT
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'content' => [
                'nullable',
                'string',
            ],

            'teaching_category_id' => [
                'required',
                'integer',
                'exists:teaching_categories,id',
            ],

            'academic_domain_id' => [
                'nullable',
                'integer',
                'exists:academic_domains,id',
            ],

            'formation_id' => [
                'nullable',
                'integer',
                'exists:formations,id',
            ],

            'filiere_id' => [
                'nullable',
                'integer',
                'exists:filieres,id',
            ],

            'program_id' => [
                'nullable',
                'integer',
                'exists:programs,id',
            ],

            'specialite_id' => [
                'nullable',
                'integer',
                'exists:specialites,id',
            ],

            'level_id' => [
                'required',
                'integer',
                'exists:levels,id',
            ],

            'subject_id' => [
                'required',
                'integer',
                'exists:subjects,id',
            ],

            'document_type_id' => [
                'required',
                'integer',
                'exists:document_types,id',
            ],

            'access_type' => [
                'required',
                'in:free,premium',
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'file_path' => [
                'required',
                'file',
                'mimes:pdf',
                'max:20480',
            ],

            'tags' => [
                'nullable',
                'array',
            ],

            'tags.*' => [
                'integer',
                'exists:tags,id',
            ],
        ]);

        /*
    |--------------------------------------------------------------------------
    | NORMALISATION DES ID
    |--------------------------------------------------------------------------
    */

        $category = TeachingCategory::query()
            ->whereKey($validated['teaching_category_id'])
            ->where('is_active', true)
            ->first();

        if (!$category) {
            return back()
                ->withErrors([
                    'teaching_category_id' =>
                    'La catégorie sélectionnée est invalide.',
                ])
                ->withInput();
        }

        $formation = null;
        $filiere = null;
        $program = null;
        $specialite = null;

        if (!empty($validated['formation_id'])) {
            $formation = Formation::query()
                ->whereKey($validated['formation_id'])
                ->where('is_active', true)
                ->first();

            if (!$formation) {
                return back()
                    ->withErrors([
                        'formation_id' =>
                        'La formation sélectionnée est invalide.',
                    ])
                    ->withInput();
            }

            /*
        |----------------------------------------------------------------------
        | Vérifier que la formation appartient à la catégorie
        |----------------------------------------------------------------------
        */

            if (
                (int) $formation->teaching_category_id !==
                (int) $category->id
            ) {
                return back()
                    ->withErrors([
                        'formation_id' =>
                        'La formation ne correspond pas à la catégorie sélectionnée.',
                    ])
                    ->withInput();
            }
        }

        /*
    |--------------------------------------------------------------------------
    | FILIÈRE
    |--------------------------------------------------------------------------
    */

        if (!empty($validated['filiere_id'])) {
            $filiere = Filiere::query()
                ->whereKey($validated['filiere_id'])
                ->where('is_active', true)
                ->first();

            if (!$filiere) {
                return back()
                    ->withErrors([
                        'filiere_id' =>
                        'La filière sélectionnée est invalide.',
                    ])
                    ->withInput();
            }

            if (
                empty($validated['academic_domain_id']) ||
                (int) $filiere->academic_domain_id !==
                (int) $validated['academic_domain_id']
            ) {
                return back()
                    ->withErrors([
                        'filiere_id' =>
                        'La filière ne correspond pas au domaine académique sélectionné.',
                    ])
                    ->withInput();
            }
        }

        /*
    |--------------------------------------------------------------------------
    | PROGRAMME
    |--------------------------------------------------------------------------
    */

        if (!empty($validated['program_id'])) {
            $program = Program::query()
                ->whereKey($validated['program_id'])
                ->where('is_active', true)
                ->first();

            if (!$program) {
                return back()
                    ->withErrors([
                        'program_id' =>
                        'Le programme sélectionné est invalide.',
                    ])
                    ->withInput();
            }

            if (
                empty($validated['formation_id']) ||
                (int) $program->formation_id !==
                (int) $validated['formation_id']
            ) {
                return back()
                    ->withErrors([
                        'program_id' =>
                        'Le programme ne correspond pas à la formation sélectionnée.',
                    ])
                    ->withInput();
            }
        }

        /*
    |--------------------------------------------------------------------------
    | SPÉCIALITÉ
    |--------------------------------------------------------------------------
    */

        if (!empty($validated['specialite_id'])) {
            $specialite = Specialite::query()
                ->whereKey($validated['specialite_id'])
                ->where('is_active', true)
                ->first();

            if (!$specialite) {
                return back()
                    ->withErrors([
                        'specialite_id' =>
                        'La spécialité sélectionnée est invalide.',
                    ])
                    ->withInput();
            }

            /*
        |----------------------------------------------------------------------
        | Spécialité liée directement à une formation
        |----------------------------------------------------------------------
        */

            if (!empty($specialite->formation_id)) {

                if (
                    empty($validated['formation_id']) ||
                    (int) $specialite->formation_id !==
                    (int) $validated['formation_id']
                ) {
                    return back()
                        ->withErrors([
                            'specialite_id' =>
                            'La spécialité ne correspond pas à la formation sélectionnée.',
                        ])
                        ->withInput();
                }
            }

            /*
        |----------------------------------------------------------------------
        | Spécialité liée à un programme
        |----------------------------------------------------------------------
        */

            if (!empty($specialite->program_id)) {

                if (
                    empty($validated['program_id']) ||
                    (int) $specialite->program_id !==
                    (int) $validated['program_id']
                ) {
                    return back()
                        ->withErrors([
                            'specialite_id' =>
                            'La spécialité ne correspond pas au programme sélectionné.',
                        ])
                        ->withInput();
                }
            }
        }

        /*
    |--------------------------------------------------------------------------
    | NIVEAU
    |--------------------------------------------------------------------------
    */

        $level = Level::query()
            ->whereKey($validated['level_id'])
            ->where('is_active', true)
            ->first();

        if (!$level) {
            return back()
                ->withErrors([
                    'level_id' =>
                    'Le niveau sélectionné est invalide.',
                ])
                ->withInput();
        }

        /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION DE LA HIÉRARCHIE DU NIVEAU
    |--------------------------------------------------------------------------
    */

        $validLevel = false;

        /*
    |----------------------------------------------------------------------
    | Formation → Level
    |
    | Secondaire
    | ENSP / ENEP / ATE
    |----------------------------------------------------------------------
    */

        if (!empty($level->formation_id)) {

            $validLevel =
                !empty($validated['formation_id']) &&
                (int) $level->formation_id ===
                (int) $validated['formation_id'];
        }

        /*
    |----------------------------------------------------------------------
    | Filière → Level
    |
    | Supérieur
    |----------------------------------------------------------------------
    */

        if (!empty($level->filiere_id)) {

            $validLevel =
                !empty($validated['filiere_id']) &&
                (int) $level->filiere_id ===
                (int) $validated['filiere_id'];
        }

        /*
    |----------------------------------------------------------------------
    | Spécialité → Level
    |
    | ENS / IDS / UIT
    |----------------------------------------------------------------------
    */

        if (!empty($level->specialite_id)) {

            $validLevel =
                !empty($validated['specialite_id']) &&
                (int) $level->specialite_id ===
                (int) $validated['specialite_id'];
        }

        if (!$validLevel) {
            return back()
                ->withErrors([
                    'level_id' =>
                    'Le niveau sélectionné ne correspond pas au parcours choisi.',
                ])
                ->withInput();
        }

        /*
    |--------------------------------------------------------------------------
    | MATIÈRE / MODULE
    |--------------------------------------------------------------------------
    */

        $subjectExists = Subject::query()
            ->whereKey($validated['subject_id'])
            ->where('level_id', $level->id)
            ->where('is_active', true)
            ->exists();

        if (!$subjectExists) {
            return back()
                ->withErrors([
                    'subject_id' =>
                    'La matière ne correspond pas au niveau sélectionné.',
                ])
                ->withInput();
        }

        /*
    |--------------------------------------------------------------------------
    | DOMAINE ACADÉMIQUE
    |--------------------------------------------------------------------------
    */

        if (!empty($validated['academic_domain_id'])) {

            $domainExists = AcademicDomain::query()
                ->whereKey($validated['academic_domain_id'])
                ->where('is_active', true)
                ->exists();

            if (!$domainExists) {
                return back()
                    ->withErrors([
                        'academic_domain_id' =>
                        'Le domaine académique sélectionné est invalide.',
                    ])
                    ->withInput();
            }
        }

        /*
    |--------------------------------------------------------------------------
    | CATÉGORIE / PARCOURS
    |--------------------------------------------------------------------------
    */

        if ($category->slug === 'higher' || $category->slug === 'superieur') {

            if (
                empty($validated['academic_domain_id']) ||
                empty($validated['filiere_id'])
            ) {
                return back()
                    ->withErrors([
                        'academic_domain_id' =>
                        'Le domaine académique et la filière sont obligatoires pour le supérieur.',
                    ])
                    ->withInput();
            }
        }

        /*
    |--------------------------------------------------------------------------
    | PREMIUM
    |--------------------------------------------------------------------------
    */

        if (
            $validated['access_type'] === 'premium' &&
            (
                !isset($validated['price']) ||
                $validated['price'] <= 0
            )
        ) {
            return back()
                ->withErrors([
                    'price' =>
                    'Le prix est obligatoire pour un document premium.',
                ])
                ->withInput();
        }

        /*
    |--------------------------------------------------------------------------
    | FICHIER PDF
    |--------------------------------------------------------------------------
    */

        $pdf = $request->file('file_path');

        $pdfPath = $pdf->store(
            'documents',
            'public'
        );

        /*
    |--------------------------------------------------------------------------
    | IMAGE DE COUVERTURE
    |--------------------------------------------------------------------------
    */

        $coverPath = null;

        if ($request->hasFile('cover_image')) {

            $coverPath = $request
                ->file('cover_image')
                ->store(
                    'covers',
                    'public'
                );
        }

        /*
    |--------------------------------------------------------------------------
    | CRÉATION
    |--------------------------------------------------------------------------
    */

        $document = Document::create([
            'staff_id' => $this->staff()->id,

            'teaching_category_id' =>
            $validated['teaching_category_id'],

            'academic_domain_id' =>
            $validated['academic_domain_id'] ?? null,

            'formation_id' =>
            $validated['formation_id'] ?? null,

            'filiere_id' =>
            $validated['filiere_id'] ?? null,

            'program_id' =>
            $validated['program_id'] ?? null,

            'specialite_id' =>
            $validated['specialite_id'] ?? null,

            'level_id' =>
            $validated['level_id'],

            'subject_id' =>
            $validated['subject_id'],

            'document_type_id' =>
            $validated['document_type_id'],

            'title' =>
            $validated['title'],

            'slug' =>
            Str::slug($validated['title']) .
                '-' .
                Str::random(8),

            'description' =>
            $validated['description'] ?? null,

            'content' =>
            $validated['content'] ?? null,

            'file_path' =>
            $pdfPath,

            'cover_image' =>
            $coverPath,

            'file_size' =>
            $pdf->getSize(),

            'file_extension' =>
            strtolower(
                $pdf->getClientOriginalExtension()
            ),

            'access_type' =>
            $validated['access_type'],

            'price' =>
            $validated['access_type'] === 'premium'
                ? $validated['price']
                : null,

            'status' =>
            'published',

            'views' =>
            0,

            'downloads' =>
            0,

            'published_at' =>
            now(),
        ]);

        /*
    |--------------------------------------------------------------------------
    | TAGS
    |--------------------------------------------------------------------------
    */

        $document->tags()->sync(
            $validated['tags'] ?? []
        );

        return redirect()
            ->route('journaliste.documents.index')
            ->with(
                'success',
                'Document publié avec succès.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | AFFICHER
    |--------------------------------------------------------------------------
    */

    public function show(Document $document)
    {
        abort_unless(
            (int)$document->staff_id ===
                (int)$this->staff()->id,
            403
        );

        $document->load([
            'staff',
            'formation',
            'filiere',
            'program',
            'specialite',
            'level',
            'subject',
            'documentType',
            'tags',
            'comments',
        ]);

        return view(
            'Documents.show',
            compact('document')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function edit(Document $document)
    {
        abort_unless(
            (int)$document->staff_id ===
                (int)$this->staff()->id,
            403
        );

        $categories = TeachingCategory::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $academicDomains = AcademicDomain::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $formations = Formation::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $filieres = Filiere::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $programs = Program::query()
            ->where('is_active', true)
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        $specialites = Specialite::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $levels = Level::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $subjects = Subject::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $documentTypes = DocumentType::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $tags = Tag::query()
            ->orderBy('name')
            ->get();

        $document->load('tags');

        return view(
            'Documents.edit',
            compact(
                'document',
                'categories',
                'academicDomains',
                'formations',
                'filieres',
                'programs',
                'specialites',
                'levels',
                'subjects',
                'documentTypes',
                'tags'
            )
        );
    }
    /*=======================
        Validation de update
        */

    private function validateDocumentHierarchy(array $validated): void
    {
        $category = TeachingCategory::query()
            ->whereKey($validated['teaching_category_id'])
            ->where('is_active', true)
            ->first();

        abort_unless(
            $category,
            422,
            'La catégorie sélectionnée est invalide.'
        );

        /*
    |--------------------------------------------------------------------------
    | FORMATION
    |--------------------------------------------------------------------------
    */

        if (!empty($validated['formation_id'])) {

            $formation = Formation::query()
                ->whereKey($validated['formation_id'])
                ->where('is_active', true)
                ->first();

            abort_unless(
                $formation,
                422,
                'La formation sélectionnée est invalide.'
            );

            abort_unless(
                (int) $formation->teaching_category_id ===
                    (int) $category->id,
                422,
                'La formation ne correspond pas à la catégorie.'
            );
        }

        /*
    |--------------------------------------------------------------------------
    | FILIÈRE
    |--------------------------------------------------------------------------
    */

        if (!empty($validated['filiere_id'])) {

            $filiere = Filiere::query()
                ->whereKey($validated['filiere_id'])
                ->where('is_active', true)
                ->first();

            abort_unless(
                $filiere,
                422,
                'La filière sélectionnée est invalide.'
            );

            abort_unless(
                !empty($validated['academic_domain_id']) &&
                    (int) $filiere->academic_domain_id ===
                    (int) $validated['academic_domain_id'],
                422,
                'La filière ne correspond pas au domaine académique.'
            );
        }

        /*
    |--------------------------------------------------------------------------
    | PROGRAMME
    |--------------------------------------------------------------------------
    */

        if (!empty($validated['program_id'])) {

            $program = Program::query()
                ->whereKey($validated['program_id'])
                ->where('is_active', true)
                ->first();

            abort_unless(
                $program,
                422,
                'Le programme sélectionné est invalide.'
            );

            abort_unless(
                !empty($validated['formation_id']) &&
                    (int) $program->formation_id ===
                    (int) $validated['formation_id'],
                422,
                'Le programme ne correspond pas à la formation.'
            );
        }

        /*
    |--------------------------------------------------------------------------
    | SPÉCIALITÉ
    |--------------------------------------------------------------------------
    */

        if (!empty($validated['specialite_id'])) {

            $specialite = Specialite::query()
                ->whereKey($validated['specialite_id'])
                ->where('is_active', true)
                ->first();

            abort_unless(
                $specialite,
                422,
                'La spécialité sélectionnée est invalide.'
            );

            if (!empty($specialite->formation_id)) {

                abort_unless(
                    !empty($validated['formation_id']) &&
                        (int) $specialite->formation_id ===
                        (int) $validated['formation_id'],
                    422,
                    'La spécialité ne correspond pas à la formation.'
                );
            }

            if (!empty($specialite->program_id)) {

                abort_unless(
                    !empty($validated['program_id']) &&
                        (int) $specialite->program_id ===
                        (int) $validated['program_id'],
                    422,
                    'La spécialité ne correspond pas au programme.'
                );
            }
        }

        /*
    |--------------------------------------------------------------------------
    | LEVEL
    |--------------------------------------------------------------------------
    */

        $level = Level::query()
            ->whereKey($validated['level_id'])
            ->where('is_active', true)
            ->first();

        abort_unless(
            $level,
            422,
            'Le niveau sélectionné est invalide.'
        );

        $validLevel = false;

        if (!empty($level->formation_id)) {

            $validLevel =
                !empty($validated['formation_id']) &&
                (int) $level->formation_id ===
                (int) $validated['formation_id'];
        }

        if (!empty($level->filiere_id)) {

            $validLevel =
                !empty($validated['filiere_id']) &&
                (int) $level->filiere_id ===
                (int) $validated['filiere_id'];
        }

        if (!empty($level->specialite_id)) {

            $validLevel =
                !empty($validated['specialite_id']) &&
                (int) $level->specialite_id ===
                (int) $validated['specialite_id'];
        }

        abort_unless(
            $validLevel,
            422,
            'Le niveau ne correspond pas au parcours sélectionné.'
        );

        /*
    |--------------------------------------------------------------------------
    | SUBJECT
    |--------------------------------------------------------------------------
    */

        $subjectExists = Subject::query()
            ->whereKey($validated['subject_id'])
            ->where('level_id', $level->id)
            ->where('is_active', true)
            ->exists();

        abort_unless(
            $subjectExists,
            422,
            'La matière ne correspond pas au niveau sélectionné.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Document $document
    ) {
        abort_unless(
            (int) $document->staff_id ===
                (int) $this->staff()->id,
            403
        );

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'content' => [
                'nullable',
                'string',
            ],

            'teaching_category_id' => [
                'required',
                'integer',
                'exists:teaching_categories,id',
            ],

            'academic_domain_id' => [
                'nullable',
                'integer',
                'exists:academic_domains,id',
            ],

            'formation_id' => [
                'nullable',
                'integer',
                'exists:formations,id',
            ],

            'filiere_id' => [
                'nullable',
                'integer',
                'exists:filieres,id',
            ],

            'program_id' => [
                'nullable',
                'integer',
                'exists:programs,id',
            ],

            'specialite_id' => [
                'nullable',
                'integer',
                'exists:specialites,id',
            ],

            'level_id' => [
                'required',
                'integer',
                'exists:levels,id',
            ],

            'subject_id' => [
                'required',
                'integer',
                'exists:subjects,id',
            ],

            'document_type_id' => [
                'required',
                'integer',
                'exists:document_types,id',
            ],

            'access_type' => [
                'required',
                'in:free,premium',
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'file_path' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:20480',
            ],

            'tags' => [
                'nullable',
                'array',
            ],

            'tags.*' => [
                'integer',
                'exists:tags,id',
            ],
        ]);

        /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION HIÉRARCHIQUE
    |--------------------------------------------------------------------------
    */

        $this->validateDocumentHierarchy($validated);

        /*
    |--------------------------------------------------------------------------
    | PREMIUM
    |--------------------------------------------------------------------------
    */

        if (
            $validated['access_type'] === 'premium' &&
            (
                !isset($validated['price']) ||
                $validated['price'] <= 0
            )
        ) {
            return back()
                ->withErrors([
                    'price' =>
                    'Le prix est obligatoire pour un document premium.',
                ])
                ->withInput();
        }

        /*
    |--------------------------------------------------------------------------
    | NOUVEAU PDF
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('file_path')) {

            if (
                $document->file_path &&
                Storage::disk('public')->exists(
                    $document->file_path
                )
            ) {
                Storage::disk('public')->delete(
                    $document->file_path
                );
            }

            $pdf = $request->file('file_path');

            $document->file_path = $pdf->store(
                'documents',
                'public'
            );

            $document->file_size = $pdf->getSize();

            $document->file_extension = strtolower(
                $pdf->getClientOriginalExtension()
            );
        }

        /*
    |--------------------------------------------------------------------------
    | NOUVELLE COUVERTURE
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('cover_image')) {

            if (
                $document->cover_image &&
                Storage::disk('public')->exists(
                    $document->cover_image
                )
            ) {
                Storage::disk('public')->delete(
                    $document->cover_image
                );
            }

            $document->cover_image = $request
                ->file('cover_image')
                ->store(
                    'covers',
                    'public'
                );
        }

        /*
    |--------------------------------------------------------------------------
    | DONNÉES DU DOCUMENT
    |--------------------------------------------------------------------------
    */

        $document->fill([
            'teaching_category_id' =>
            $validated['teaching_category_id'],

            'academic_domain_id' =>
            $validated['academic_domain_id'] ?? null,

            'formation_id' =>
            $validated['formation_id'] ?? null,

            'filiere_id' =>
            $validated['filiere_id'] ?? null,

            'program_id' =>
            $validated['program_id'] ?? null,

            'specialite_id' =>
            $validated['specialite_id'] ?? null,

            'level_id' =>
            $validated['level_id'],

            'subject_id' =>
            $validated['subject_id'],

            'document_type_id' =>
            $validated['document_type_id'],

            'title' =>
            $validated['title'],

            'slug' =>
            Str::slug($validated['title']) .
                '-' .
                $document->id,

            'description' =>
            $validated['description'] ?? null,

            'content' =>
            $validated['content'] ?? null,

            'access_type' =>
            $validated['access_type'],

            'price' =>
            $validated['access_type'] === 'premium'
                ? $validated['price']
                : null,
        ]);

        $document->save();

        /*
    |--------------------------------------------------------------------------
    | TAGS
    |--------------------------------------------------------------------------
    */

        $document->tags()->sync(
            $validated['tags'] ?? []
        );

        return redirect()
            ->route('journaliste.documents.index')
            ->with(
                'success',
                'Document modifié avec succès.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DOCUMENTS PUBLIÉS
    |--------------------------------------------------------------------------
    */

    public function published()
    {
        $documents = $this->myDocuments()
            ->where('status', 'published')
            ->with([
                'staff',
                'formation',
                'filiere',
                'program',
                'specialite',
                'level',
                'subject',
                'documentType',
            ])
            ->latest()
            ->paginate(10);

        return view(
            'Documents.published',
            compact('documents')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER
    |--------------------------------------------------------------------------
    */

    public function destroy(Document $document)
    {
        abort_unless(
            (int)$document->staff_id ===
                (int)$this->staff()->id,
            403
        );

        if (
            $document->file_path &&
            Storage::disk('public')->exists(
                $document->file_path
            )
        ) {
            Storage::disk('public')->delete(
                $document->file_path
            );
        }

        if (
            $document->cover_image &&
            Storage::disk('public')->exists(
                $document->cover_image
            )
        ) {
            Storage::disk('public')->delete(
                $document->cover_image
            );
        }

        $document->tags()->detach();

        $document->delete();

        return redirect()
            ->route('journaliste.documents.index')
            ->with(
                'success',
                'Document supprimé avec succès.'
            );
    }
}
