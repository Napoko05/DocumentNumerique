<?php
use App\Models\AcademicDomain;
use App\Models\Formation;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Filiere;
use App\Models\Level;



public function typeDocuments(
    string $domaineSlug,
    string $formationSlug,
    string $filiereSlug,
    string $niveauSlug
) {


    $domaine = AcademicDomain::where('slug', $domaineSlug)
        ->where('is_active', true)
        ->firstOrFail();



    $formation = Formation::where('academic_domain_id', $domaine->id)
        ->where('slug', $formationSlug)
        ->where('is_active', true)
        ->firstOrFail();



    $filiere = Filiere::where('formation_id', $formation->id)
        ->where('slug', $filiereSlug)
        ->where('is_active', true)
        ->firstOrFail();



    $niveau = Level::where('filiere_id', $filiere->id)
        ->where('slug', $niveauSlug)
        ->where('is_active', true)
        ->firstOrFail();



    $types = DocumentType::where('is_active', true)
        ->orderBy('name')
        ->get();



    foreach ($types as $type) {

        $type->documents_count = Document::where('formation_id', $formation->id)
            ->where('filiere_id', $filiere->id)
            ->where('level_id', $niveau->id)
            ->where('document_type_id', $type->id)
            ->where('status', 'published')
            ->count();

    }



    return view(
        'niveau.superieur.type_doc',
        compact(
            'domaine',
            'formation',
            'filiere',
            'niveau',
            'types'
        )
    );

}

