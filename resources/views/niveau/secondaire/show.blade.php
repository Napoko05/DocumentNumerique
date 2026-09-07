@extends('layouts.app')

@section('title', $document->title)

@section('content')

<div class="vitrine-page">

    <div class="breadcrumb-vitrine">

        <a href="{{ url('/') }}">
            Accueil
        </a>

        <i class="bi bi-chevron-right"></i>

        <span>Secondaire</span>

        <i class="bi bi-chevron-right"></i>

        <span>{{ $formationModel->name }}</span>

        <i class="bi bi-chevron-right"></i>

        <span>{{ $level->name }}</span>

        <i class="bi bi-chevron-right"></i>

        <span>{{ $subject->name }}</span>

        <i class="bi bi-chevron-right"></i>

        <strong>Document</strong>

    </div>

    <article class="document-show">

        {{-- =========================================================
             EN-TÊTE
        ========================================================== --}}

        <div class="document-show-header">

            <div class="document-show-type">

                <span class="page-kicker">
                    {{ $document->documentType->name ?? 'DOCUMENT' }}
                </span>

                @if($document->isPremium())

                    <span class="badge-premium">
                        <i class="bi bi-lock-fill"></i>
                        Premium
                    </span>

                @else

                    <span class="badge-free">
                        <i class="bi bi-unlock-fill"></i>
                        Gratuit
                    </span>

                @endif

            </div>

            <h1>
                {{ $document->title }}
            </h1>

            @if($document->description)

                <p class="document-description">
                    {{ $document->description }}
                </p>

            @endif

        </div>


        {{-- =========================================================
             DOCUMENT PDF
        ========================================================== --}}

        <div class="document-reader">

            @if($document->isFree())

                <div class="pdf-viewer">

                    <iframe
                        src="{{ asset('storage/' . $document->file_path) }}"
                        title="{{ $document->title }}"
                        loading="lazy"
                    ></iframe>

                </div>

            @elseif($document->isPremium())

                @auth

                    @if($document->userHasAccess(auth()->id()))

                        {{-- PREMIUM PAYÉ : DOCUMENT COMPLET --}}

                        <div class="pdf-viewer">

                            <iframe
                                src="{{ asset('storage/' . $document->file_path) }}"
                                title="{{ $document->title }}"
                                loading="lazy"
                            ></iframe>

                        </div>

                    @else

                        {{-- PREMIUM NON PAYÉ --}}

                        <div class="premium-preview-block">

                            <div class="premium-preview-icon">
                                <i class="bi bi-lock-fill"></i>
                            </div>

                            <h2>
                                Document premium
                            </h2>

                            <p>
                                Ce document est disponible après paiement.
                            </p>

                            <div class="premium-price">

                                {{ number_format(
                                    (float) $document->price,
                                    0,
                                    ',',
                                    ' '
                                ) }}

                                FCFA

                            </div>

                            <a
                                href="{{ route(
                                    'payments.create',
                                    ['document' => $document->id]
                                ) }}"
                                class="btn-document-payment"
                            >

                                <i class="bi bi-credit-card"></i>

                                Payer et accéder au document

                                <i class="bi bi-arrow-right"></i>

                            </a>

                        </div>

                    @endif

                @else

                    {{-- PREMIUM NON CONNECTÉ --}}

                    <div class="premium-preview-block">

                        <div class="premium-preview-icon">
                            <i class="bi bi-lock-fill"></i>
                        </div>

                        <h2>
                            Document premium
                        </h2>

                        <p>
                            Connectez-vous pour consulter ce document.
                        </p>

                        <a
                            href="{{ route('login') }}"
                            class="btn-document-payment"
                        >

                            <i class="bi bi-box-arrow-in-right"></i>

                            Se connecter

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    </div>

                @endauth

            @endif

        </div>


        {{-- =========================================================
             INFORMATIONS
        ========================================================== --}}

        <div class="document-information document-information-show">

            <div class="info-item">

                <span>Formation</span>

                <strong>
                    {{ $formationModel->name }}
                </strong>

            </div>

            <div class="info-item">

                <span>Niveau</span>

                <strong>
                    {{ $level->name }}
                </strong>

            </div>

            <div class="info-item">

                <span>Matière</span>

                <strong>
                    {{ $subject->name }}
                </strong>

            </div>

            <div class="info-item">

                <span>Type</span>

                <strong>
                    {{ $document->documentType->name ?? 'Document' }}
                </strong>

            </div>

            @if($document->file_size)

                <div class="info-item">

                    <span>Taille</span>

                    <strong>
                        {{ number_format(
                            $document->file_size / 1024 / 1024,
                            2
                        ) }}
                        Mo
                    </strong>

                </div>

            @endif

        </div>


        {{-- =========================================================
             TÉLÉCHARGEMENT
        ========================================================== --}}

        <div class="document-download-area">

            @if($document->isFree())

                <a
                    href="{{ asset('storage/' . $document->file_path) }}"
                    download
                    class="btn-document-download"
                >

                    <i class="bi bi-download"></i>

                    Télécharger le document

                </a>

            @elseif($document->isPremium())

                @auth

                    @if($document->userHasAccess(auth()->id()))

                        <a
                            href="{{ asset('storage/' . $document->file_path) }}"
                            download
                            class="btn-document-download"
                        >

                            <i class="bi bi-download"></i>

                            Télécharger le document

                        </a>

                    @else

                        <a
                            href="{{ route(
                                'payments.create',
                                ['document' => $document->id]
                            ) }}"
                            class="btn-document-payment"
                        >

                            <i class="bi bi-lock-fill"></i>

                            Débloquer le téléchargement

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    @endif

                @else

                    <a
                        href="{{ route('login') }}"
                        class="btn-document-payment"
                    >

                        <i class="bi bi-box-arrow-in-right"></i>

                        Se connecter pour télécharger

                    </a>

                @endauth

            @endif

        </div>


        {{-- =========================================================
             CONTENU / DESCRIPTION
        ========================================================== --}}

        @if($document->content)

            <div class="document-content">

                <div class="section-heading">

                    <div>

                        <span class="section-kicker">
                            CONTENU
                        </span>

                        <h2>
                            Présentation du document
                        </h2>

                    </div>

                </div>

                <div class="document-content-body">
                    {!! $document->content !!}
                </div>

            </div>

        @endif


        {{-- =========================================================
             TAGS
        ========================================================== --}}

        @if($document->tags->isNotEmpty())

            <div class="document-tags">

                @foreach($document->tags as $tag)

                    <span>
                        #{{ $tag->name }}
                    </span>

                @endforeach

            </div>

        @endif

    </article>


    {{-- =========================================================
         RETOUR
    ========================================================== --}}

    <a
        href="{{ route(
            'vitrine.secondaire.subject',
            [
                'formation' => $formationModel->slug,
                'niveau' => $level->slug,
                'matiere' => $subject->slug,
            ]
        ) }}"
        class="vitrine-back"
    >

        <i class="bi bi-arrow-left"></i>

        Retour à {{ $subject->name }}

    </a>

</div>


<style>

.document-reader {
    width: 100%;
    margin-top: 30px;
}

.pdf-viewer {
    width: 100%;
    height: 850px;
    background: #e5e7eb;
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid #dbe3ec;
}

.pdf-viewer iframe {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
}

.premium-preview-block {
    min-height: 430px;
    padding: 60px 25px;
    border-radius: 18px;
    background: #fff7ed;
    border: 1px solid #fed7aa;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.premium-preview-icon {
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #F58220;
    color: #fff;
    font-size: 28px;
    margin-bottom: 20px;
}

.premium-preview-block h2 {
    margin: 0 0 10px;
    color: #9a3412;
}

.premium-preview-block p {
    margin: 0 0 18px;
    color: #7c2d12;
}

.premium-price {
    font-size: 24px;
    font-weight: 800;
    color: #F58220;
    margin-bottom: 22px;
}

.document-information-show {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
    margin-top: 25px;
}

.document-download-area {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
}

.btn-document-download,
.btn-document-payment {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 13px 20px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
    transition: .25s ease;
}

.btn-document-download {
    background: #f1f5f9;
    border: 1px solid #dbe3ec;
    color: #334155;
}

.btn-document-download:hover {
    background: #e2e8f0;
    color: #0f172a;
    transform: translateY(-2px);
}

.btn-document-payment {
    background: #F58220;
    color: #fff;
}

.btn-document-payment:hover {
    background: #d96d12;
    color: #fff;
    transform: translateY(-2px);
}

@media (max-width: 900px) {

    .document-information-show {
        grid-template-columns: repeat(2, 1fr);
    }

    .pdf-viewer {
        height: 700px;
    }

}

@media (max-width: 600px) {

    .document-information-show {
        grid-template-columns: 1fr;
    }

    .pdf-viewer {
        height: 600px;
    }

    .document-download-area {
        justify-content: stretch;
    }

    .btn-document-download,
    .btn-document-payment {
        width: 100%;
    }

}

</style>

@endsection