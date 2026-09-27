
@extends('layouts.app')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Vérification du paiement
    |--------------------------------------------------------------------------
    */

    $isPaid = false;

    if (auth()->check() && $document->access_type !== 'free') {
        $isPaid = \App\Models\Payment::where('user_id', auth()->id())
            ->where('document_id', $document->id)
            ->where('status', 'paid')
            ->exists();
    }
@endphp


{{-- ============================================================
     CSS COMPLET DE LA PAGE
============================================================ --}}
@push('styles')
<style>

    /* ============================================================
       VARIABLES
    ============================================================ */

    .public-document-page {
        --pd-primary: #123b63;
        --pd-primary-dark: #0b2d4d;
        --pd-primary-light: #eaf2f9;

        --pd-accent: #d99a2b;
        --pd-text: #172033;
        --pd-muted: #64748b;

        --pd-border: #e2e8f0;
        --pd-bg: #f5f7fa;

        --pd-green: #15803d;
        --pd-green-bg: #dcfce7;
        --pd-green-border: #bbf7d0;

        --pd-red: #b91c1c;
        --pd-red-bg: #fef2f2;

        width: 100%;
        min-height: calc(100vh - 4rem);

        background:
            radial-gradient(
                circle at 10% 10%,
                rgba(217, 154, 43, 0.06),
                transparent 30%
            ),
            radial-gradient(
                circle at 90% 90%,
                rgba(18, 59, 99, 0.07),
                transparent 35%
            ),
            var(--pd-bg);

        padding: 45px 20px 70px;

        box-sizing: border-box;
    }


    /* ============================================================
       CONTAINER
    ============================================================ */

    .public-document-container {
        width: 100%;
        max-width: 1180px;

        margin: 0 auto;
    }


    /* ============================================================
       BREADCRUMB
    ============================================================ */

    .public-document-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 9px;

        margin-bottom: 24px;

        color: var(--pd-muted);

        font-size: 13px;
    }

    .public-document-breadcrumb a {
        color: var(--pd-primary);

        font-weight: 700;

        text-decoration: none;

        transition:
            color 0.2s ease;
    }

    .public-document-breadcrumb a:hover {
        color: var(--pd-accent);
    }

    .public-document-breadcrumb span:last-child {
        max-width: 420px;

        overflow: hidden;

        text-overflow: ellipsis;

        white-space: nowrap;
    }


    /* ============================================================
       LAYOUT PRINCIPAL
    ============================================================ */

    .public-document-layout {
        display: grid;

        grid-template-columns: 360px minmax(0, 1fr);

        gap: 40px;

        align-items: start;
    }


    /* ============================================================
       CARTE COUVERTURE
    ============================================================ */

    .public-document-cover-card {
        position: sticky;

        top: 25px;

        padding: 14px;

        background: #ffffff;

        border: 1px solid var(--pd-border);

        border-radius: 22px;

        box-shadow:
            0 18px 45px rgba(15, 23, 42, 0.08);
    }

    .public-document-cover {
        position: relative;

        width: 100%;

        aspect-ratio: 3 / 4;

        overflow: hidden;

        border-radius: 15px;

        background:
            linear-gradient(
                145deg,
                #eaf2f9,
                #f8fafc
            );
    }

    .public-document-cover img {
        display: block;

        width: 100%;
        height: 100%;

        object-fit: cover;
    }

    .public-document-cover-placeholder {
        width: 100%;
        height: 100%;

        display: flex;

        align-items: center;
        justify-content: center;

        color: var(--pd-primary);

        font-size: 80px;
    }


    /* ============================================================
       CONTENU
    ============================================================ */

    .public-document-content {
        min-width: 0;

        padding: 8px 0;
    }


    /* ============================================================
       BADGES
    ============================================================ */

    .public-document-badges {
        display: flex;

        align-items: center;

        flex-wrap: wrap;

        gap: 9px;

        margin-bottom: 17px;
    }

    .public-document-badge {
        display: inline-flex;

        align-items: center;

        gap: 7px;

        min-height: 32px;

        padding: 6px 12px;

        border-radius: 999px;

        font-size: 12px;

        font-weight: 800;

        line-height: 1;

        box-sizing: border-box;
    }

    .public-document-badge i {
        font-size: 13px;
    }

    .public-document-badge-category {
        background: #f1f5f9;

        color: #475569;

        border: 1px solid #e2e8f0;
    }

    .public-document-badge-free {
        background: #ecfdf5;

        color: #047857;

        border: 1px solid #a7f3d0;
    }

    .public-document-badge-premium {
        background: #fff7ed;

        color: #c2410c;

        border: 1px solid #fed7aa;
    }

    /* Badge PAYÉ */
    .public-document-badge-paid {
        background: var(--pd-green-bg);

        color: var(--pd-green);

        border: 1px solid var(--pd-green-border);

        box-shadow:
            0 3px 10px rgba(21, 128, 61, 0.08);
    }


    /* ============================================================
       TITRE
    ============================================================ */

    .public-document-title {
        margin: 0 0 17px;

        color: var(--pd-text);

        font-size: clamp(28px, 4vw, 42px);

        line-height: 1.13;

        font-weight: 850;

        letter-spacing: -1px;
    }


    /* ============================================================
       DESCRIPTION
    ============================================================ */

    .public-document-description {
        margin-bottom: 27px;

        padding: 19px 21px;

        color: #475569;

        background: #ffffff;

        border: 1px solid var(--pd-border);

        border-radius: 15px;

        font-size: 14px;

        line-height: 1.8;

        box-shadow:
            0 7px 22px rgba(15, 23, 42, 0.035);
    }


    /* ============================================================
       INFORMATIONS DU DOCUMENT
    ============================================================ */

    .public-document-info {
        display: grid;

        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 12px;

        margin-bottom: 28px;
    }

    .public-document-info-item {
        min-width: 0;

        padding: 16px;

        background: #ffffff;

        border: 1px solid var(--pd-border);

        border-radius: 14px;

        box-shadow:
            0 5px 18px rgba(15, 23, 42, 0.035);
    }

    .public-document-info-label {
        display: flex;

        align-items: center;

        gap: 7px;

        margin-bottom: 7px;

        color: var(--pd-muted);

        font-size: 12px;

        font-weight: 700;
    }

    .public-document-info-label i {
        color: var(--pd-primary);

        font-size: 13px;
    }

    .public-document-info-item strong {
        display: block;

        color: var(--pd-text);

        font-size: 14px;

        font-weight: 800;

        overflow-wrap: anywhere;
    }

    .public-document-paid-text {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        color: var(--pd-green) !important;
    }

    .public-document-paid-text i {
        font-size: 14px;
    }


    /* ============================================================
       ZONE D'ACCÈS
    ============================================================ */

    .public-document-access {
        overflow: hidden;

        background: #ffffff;

        border: 1px solid var(--pd-border);

        border-radius: 20px;

        box-shadow:
            0 12px 32px rgba(15, 23, 42, 0.06);
    }


    /* ============================================================
       HEADER ACCÈS
    ============================================================ */

    .public-document-access-header {
        display: flex;

        align-items: center;

        gap: 15px;

        padding: 22px 23px;

        border-bottom: 1px solid var(--pd-border);
    }

    .public-document-access-icon {
        width: 46px;
        height: 46px;

        flex: 0 0 46px;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 13px;

        font-size: 20px;
    }

    .public-document-access-header h2 {
        margin: 0 0 5px;

        color: var(--pd-text);

        font-size: 17px;

        font-weight: 800;
    }

    .public-document-access-header p {
        margin: 0;

        color: var(--pd-muted);

        font-size: 13px;

        line-height: 1.55;
    }


    /* GRATUIT */

    .public-document-access-header-free {
        background: #f0fdf4;
    }

    .public-document-access-header-free
    .public-document-access-icon {
        background: #dcfce7;

        color: #15803d;
    }


    /* PAYÉ */

    .public-document-access-header-paid {
        background:
            linear-gradient(
                90deg,
                #f0fdf4,
                #ffffff
            );
    }

    .public-document-access-header-paid
    .public-document-access-icon {
        background: var(--pd-green-bg);

        color: var(--pd-green);

        box-shadow:
            0 5px 14px rgba(21, 128, 61, 0.12);
    }


    /* PREMIUM */

    .public-document-access-header-premium {
        background:
            linear-gradient(
                90deg,
                #fffaf3,
                #ffffff
            );
    }

    .public-document-access-header-premium
    .public-document-access-icon {
        background: #ffedd5;

        color: #c2410c;
    }


    /* ============================================================
       PRIX
    ============================================================ */

    .public-document-price {
        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 20px;

        margin: 20px 23px;

        padding: 18px 20px;

        background: #f8fafc;

        border: 1px solid #e2e8f0;

        border-radius: 14px;
    }

    .public-document-price span {
        color: var(--pd-muted);

        font-size: 13px;

        font-weight: 700;
    }

    .public-document-price strong {
        color: var(--pd-primary);

        font-size: 22px;

        font-weight: 850;

        white-space: nowrap;
    }


    /* ============================================================
       INFORMATION PAIEMENT
    ============================================================ */

    .public-document-payment-info {
        margin: 0 23px 20px;

        padding: 17px 19px;

        background: #f8fafc;

        border-left: 4px solid var(--pd-primary);

        border-radius: 10px;
    }

    .public-document-payment-info h3 {
        display: flex;

        align-items: center;

        gap: 8px;

        margin: 0 0 7px;

        color: var(--pd-primary);

        font-size: 14px;

        font-weight: 800;
    }

    .public-document-payment-info h3 i {
        font-size: 16px;
    }

    .public-document-payment-info p {
        margin: 0;

        color: var(--pd-muted);

        font-size: 13px;

        line-height: 1.6;
    }


    /* ============================================================
       BOUTONS
    ============================================================ */

    .public-document-actions {
        display: flex;

        align-items: center;

        flex-wrap: wrap;

        gap: 12px;

        padding: 20px 23px 23px;
    }

    .public-document-button {
        min-height: 48px;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 9px;

        padding: 0 20px;

        border: 1px solid transparent;

        border-radius: 11px;

        font-size: 13px;

        font-weight: 800;

        text-decoration: none;

        cursor: pointer;

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            background 0.2s ease,
            border-color 0.2s ease;
    }

    .public-document-button:hover {
        transform: translateY(-1px);

        text-decoration: none;
    }

    .public-document-button i {
        font-size: 16px;
    }


    /* LIRE */

    .public-document-button-read {
        color: #ffffff;

        background:
            linear-gradient(
                135deg,
                var(--pd-primary),
                #174e7e
            );

        border-color: var(--pd-primary);

        box-shadow:
            0 7px 16px rgba(18, 59, 99, 0.18);
    }

    .public-document-button-read:hover {
        color: #ffffff;

        box-shadow:
            0 10px 22px rgba(18, 59, 99, 0.25);
    }


    /* TÉLÉCHARGER */

    .public-document-button-download {
        color: var(--pd-primary);

        background: #ffffff;

        border-color: #cbd5e1;
    }

    .public-document-button-download:hover {
        color: var(--pd-primary);

        background: var(--pd-primary-light);

        border-color: #a9bfd3;
    }


    /* PAIEMENT */

    .public-document-button-payment {
        color: #ffffff;

        background:
            linear-gradient(
                135deg,
                #c98618,
                var(--pd-accent)
            );

        border-color: var(--pd-accent);

        box-shadow:
            0 7px 16px rgba(217, 154, 43, 0.20);
    }

    .public-document-button-payment:hover {
        color: #ffffff;

        box-shadow:
            0 10px 22px rgba(217, 154, 43, 0.28);
    }


    /* CONNEXION */

    .public-document-button-login {
        color: #ffffff;

        background: var(--pd-primary);

        border-color: var(--pd-primary);

        box-shadow:
            0 7px 16px rgba(18, 59, 99, 0.18);
    }

    .public-document-button-login:hover {
        color: #ffffff;

        background: var(--pd-primary-dark);
    }


    /* ============================================================
       RETOUR
    ============================================================ */

    .public-document-back {
        margin-top: 22px;

        text-align: center;
    }

    .public-document-back a {
        display: inline-flex;

        align-items: center;

        gap: 7px;

        color: var(--pd-muted);

        font-size: 13px;

        font-weight: 700;

        text-decoration: none;

        transition:
            color 0.2s ease;
    }

    .public-document-back a:hover {
        color: var(--pd-primary);
    }


    /* ============================================================
       RESPONSIVE — TABLETTE
    ============================================================ */

    @media (max-width: 950px) {

        .public-document-page {
            padding: 35px 18px 55px;
        }

        .public-document-layout {
            grid-template-columns: 290px minmax(0, 1fr);

            gap: 28px;
        }

        .public-document-title {
            font-size: 32px;
        }

        .public-document-cover-card {
            top: 15px;
        }
    }


    /* ============================================================
       RESPONSIVE — MOBILE
    ============================================================ */

    @media (max-width: 760px) {

        .public-document-page {
            padding: 25px 14px 45px;
        }

        .public-document-layout {
            grid-template-columns: 1fr;

            gap: 25px;
        }

        .public-document-cover-card {
            position: relative;

            top: auto;

            max-width: 330px;

            width: 100%;

            margin: 0 auto;
        }

        .public-document-content {
            padding: 0;
        }

        .public-document-title {
            font-size: 28px;

            letter-spacing: -0.6px;
        }

        .public-document-info {
            grid-template-columns: 1fr;
        }

        .public-document-access-header {
            align-items: flex-start;

            padding: 19px;
        }

        .public-document-actions {
            flex-direction: column;

            align-items: stretch;

            padding: 18px 19px 20px;
        }

        .public-document-button {
            width: 100%;

            box-sizing: border-box;
        }

        .public-document-price {
            align-items: flex-start;

            flex-direction: column;

            gap: 8px;

            margin: 18px 19px;
        }

        .public-document-payment-info {
            margin-left: 19px;
            margin-right: 19px;
        }
    }


    /* ============================================================
       PETIT MOBILE
    ============================================================ */

    @media (max-width: 480px) {

        .public-document-breadcrumb {
            font-size: 12px;
        }

        .public-document-breadcrumb span:last-child {
            max-width: 180px;
        }

        .public-document-title {
            font-size: 25px;
        }

        .public-document-description {
            padding: 16px;

            font-size: 13px;
        }

        .public-document-info-item {
            padding: 14px;
        }

        .public-document-access-header {
            gap: 11px;
        }

        .public-document-access-icon {
            width: 42px;
            height: 42px;

            flex-basis: 42px;

            font-size: 18px;
        }

        .public-document-access-header h2 {
            font-size: 15px;
        }

        .public-document-access-header p {
            font-size: 12px;
        }

        .public-document-price strong {
            font-size: 20px;
        }
    }

</style>
@endpush


<section class="public-document-page">

    <div class="public-document-container">


        {{-- ========================================================
             BREADCRUMB
        ========================================================= --}}
        <nav
            class="public-document-breadcrumb"
            aria-label="Fil d'Ariane"
        >

            <a href="{{ route('home') }}">
                Accueil
            </a>

            <span>/</span>

            <a href="{{ route('documents.index') }}">
                Documents
            </a>

            <span>/</span>

            <span>
                {{ $document->title }}
            </span>

        </nav>


        {{-- ========================================================
             LAYOUT
        ========================================================= --}}
        <div class="public-document-layout">


            {{-- ====================================================
                 COUVERTURE
            ===================================================== --}}
            <aside class="public-document-cover-card">

                <div class="public-document-cover">

                    @if($document->cover_image)

                        <img
                            src="{{ asset('storage/'.$document->cover_image) }}"
                            alt="{{ $document->title }}"
                        >

                    @else

                        <div class="public-document-cover-placeholder">

                            <i class="bi bi-file-earmark-text"></i>

                        </div>

                    @endif

                </div>

            </aside>


            {{-- ====================================================
                 INFORMATIONS
            ===================================================== --}}
            <main class="public-document-content">


                {{-- ==================================================
                     BADGES
                =================================================== --}}
                <div class="public-document-badges">

                    @if($document->category)

                        <span class="public-document-badge public-document-badge-category">

                            <i class="bi bi-folder2-open"></i>

                            {{ $document->category }}

                        </span>

                    @endif


                    @if($document->access_type === 'free')

                        <span class="public-document-badge public-document-badge-free">

                            <i class="bi bi-unlock"></i>

                            Gratuit

                        </span>

                    @elseif($isPaid)

                        <span class="public-document-badge public-document-badge-paid">

                            <i class="bi bi-check-circle-fill"></i>

                            Payé

                        </span>

                    @else

                        <span class="public-document-badge public-document-badge-premium">

                            <i class="bi bi-star-fill"></i>

                            Premium

                        </span>

                    @endif

                </div>


                {{-- ==================================================
                     TITRE
                =================================================== --}}
                <h1 class="public-document-title">

                    {{ $document->title }}

                </h1>


                {{-- ==================================================
                     DESCRIPTION
                =================================================== --}}
                @if($document->description)

                    <div class="public-document-description">

                        {{ $document->description }}

                    </div>

                @endif


                {{-- ==================================================
                     INFORMATIONS
                =================================================== --}}
                <div class="public-document-info">


                    @if($document->level?->name)

                        <div class="public-document-info-item">

                            <span class="public-document-info-label">

                                <i class="bi bi-mortarboard-fill"></i>

                                Niveau

                            </span>

                            <strong>

                                {{ $document->level->name }}

                            </strong>

                        </div>

                    @endif


                    @if($document->cycle)

                        <div class="public-document-info-item">

                            <span class="public-document-info-label">

                                <i class="bi bi-diagram-3-fill"></i>

                                Cycle

                            </span>

                            <strong>

                                {{ $document->cycle }}

                            </strong>

                        </div>

                    @endif


                    <div class="public-document-info-item">

                        <span class="public-document-info-label">

                            <i class="bi bi-eye-fill"></i>

                            Vues

                        </span>

                        <strong>

                            {{ number_format($document->views ?? 0) }}

                        </strong>

                    </div>


                    <div class="public-document-info-item">

                        <span class="public-document-info-label">

                            <i class="bi bi-tag-fill"></i>

                            Accès

                        </span>

                        <strong>

                            @if($document->access_type === 'free')

                                Gratuit

                            @elseif($isPaid)

                                <span class="public-document-paid-text">

                                    <i class="bi bi-check-circle-fill"></i>

                                    Payé

                                </span>

                            @else

                                {{ number_format((float) $document->price, 0, ' ', ' ') }}
                                FCFA

                            @endif

                        </strong>

                    </div>

                </div>


                {{-- ==================================================
                     ACCÈS
                =================================================== --}}
                <div class="public-document-access">


                    {{-- =================================================
                         GRATUIT
                    ================================================== --}}
                    @if($document->access_type === 'free')

                        <div class="public-document-access-header public-document-access-header-free">

                            <div class="public-document-access-icon">

                                <i class="bi bi-unlock-fill"></i>

                            </div>

                            <div>

                                <h2>
                                    Document accessible
                                </h2>

                                <p>
                                    Ce document est disponible gratuitement.
                                </p>

                            </div>

                        </div>


                        <div class="public-document-actions">

                            <a
                                href="{{ route('documents.read', $document) }}"
                                target="_blank"
                                class="public-document-button public-document-button-read"
                            >

                                <i class="bi bi-book"></i>

                                <span>
                                    Lire le document
                                </span>

                            </a>


                            <a
                                href="{{ route('documents.download', $document) }}"
                                class="public-document-button public-document-button-download"
                            >

                                <i class="bi bi-download"></i>

                                <span>
                                    Télécharger
                                </span>

                            </a>

                        </div>


                    {{-- =================================================
                         PAYÉ
                    ================================================== --}}
                    @elseif($isPaid)

                        <div class="public-document-access-header public-document-access-header-paid">

                            <div class="public-document-access-icon">

                                <i class="bi bi-check-circle-fill"></i>

                            </div>

                            <div>

                                <h2>
                                    Document payé
                                </h2>

                                <p>
                                    Votre paiement a été validé.
                                    Vous avez accès à ce document.
                                </p>

                            </div>

                        </div>


                        <div class="public-document-actions">

                            <a
                                href="{{ route('documents.read', $document) }}"
                                target="_blank"
                                class="public-document-button public-document-button-read"
                            >

                                <i class="bi bi-book"></i>

                                <span>
                                    Ouvrir le document
                                </span>

                            </a>


                            <a
                                href="{{ route('documents.download', $document) }}"
                                class="public-document-button public-document-button-download"
                            >

                                <i class="bi bi-download"></i>

                                <span>
                                    Télécharger
                                </span>

                            </a>

                        </div>


                    {{-- =================================================
                         PREMIUM NON PAYÉ
                    ================================================== --}}
                    @else

                        <div class="public-document-access-header public-document-access-header-premium">

                            <div class="public-document-access-icon">

                                <i class="bi bi-lock-fill"></i>

                            </div>

                            <div>

                                <h2>
                                    Accès Premium
                                </h2>

                                <p>
                                    Le paiement est nécessaire pour accéder
                                    à ce document.
                                </p>

                            </div>

                        </div>


                        <div class="public-document-price">

                            <span>
                                Prix du document
                            </span>

                            <strong>

                                {{ number_format((float) $document->price, 0, ' ', ' ') }}

                                FCFA

                            </strong>

                        </div>


                        <div class="public-document-payment-info">

                            <h3>

                                <i class="bi bi-shield-check"></i>

                                Accès après paiement

                            </h3>

                            <p>

                                Après validation du paiement, vous pourrez
                                lire le document et le télécharger depuis
                                cette page.

                            </p>

                        </div>


                        <div class="public-document-actions">

                            @auth

                                <a
                                    href="{{ route('payments.create', $document) }}"
                                    class="public-document-button public-document-button-payment"
                                >

                                    <i class="bi bi-credit-card"></i>

                                    <span>
                                        Procéder au paiement
                                    </span>

                                </a>

                            @else

                                <a
                                    href="{{ route('login') }}"
                                    class="public-document-button public-document-button-login"
                                >

                                    <i class="bi bi-box-arrow-in-right"></i>

                                    <span>
                                        Se connecter pour payer
                                    </span>

                                </a>

                            @endauth

                        </div>

                    @endif

                </div>


                {{-- ==================================================
                     RETOUR
                =================================================== --}}
                <div class="public-document-back">

                    <a href="{{ route('documents.index') }}">

                        <i class="bi bi-arrow-left"></i>

                        Retour aux documents

                    </a>

                </div>

            </main>

        </div>

    </div>

</section>

@endsection
