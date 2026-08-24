@extends('layouts.journaliste_app')

@section('page-title', 'Mes revenus')

@section('content')

<div class="journalist-page">

    {{-- EN-TÊTE --}}
    <div class="page-header">

        <div>
            <span class="page-kicker">
                FINANCES
            </span>

            <h1>
                Mes revenus
            </h1>

            <p>
                Consultez les paiements générés par vos documents premium.
            </p>
        </div>

        <a href="{{ route('journaliste.documents.index') }}"
           class="btn-primary-custom">

            <i class="fas fa-file-alt"></i>

            Mes documents

        </a>

    </div>


    {{-- RÉSUMÉ FINANCIER --}}
    <div class="revenue-summary">

        <div class="revenue-card main-revenue">

            <div class="revenue-icon">
                <i class="fas fa-wallet"></i>
            </div>

            <div>
                <span>Revenus totaux</span>

                <strong>
                    {{ number_format($totalRevenue ?? 0, 0, ',', ' ') }}
                    <small>FCFA</small>
                </strong>
            </div>

        </div>


        <div class="revenue-card">

            <div class="revenue-icon blue-icon">
                <i class="fas fa-credit-card"></i>
            </div>

            <div>
                <span>Paiements reçus</span>

                <strong>
                    {{ number_format($totalPayments ?? 0, 0, ',', ' ') }}
                </strong>
            </div>

        </div>

    </div>


    {{-- HISTORIQUE --}}
    <div class="content-card">

        <div class="content-card-header">

            <div>
                <h2>
                    Historique des paiements
                </h2>

                <p>
                    Liste des paiements effectués pour vos documents.
                </p>
            </div>

        </div>


        @if($payments->isEmpty())

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="fas fa-wallet"></i>
                </div>

                <h3>
                    Aucun paiement
                </h3>

                <p>
                    Vous n'avez encore reçu aucun paiement.
                </p>

                <a href="{{ route('journaliste.documents.create') }}"
                   class="btn-primary-custom">

                    <i class="fas fa-plus"></i>

                    Ajouter un document

                </a>

            </div>

        @else

            <div class="table-wrapper">

                <table class="professional-table">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Document</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($payments as $index => $payment)

                            <tr>

                                <td>
                                    <span class="table-number">
                                        {{ $payments->firstItem() + $index }}
                                    </span>
                                </td>

                                <td>

                                    <div class="document-name">

                                        <div class="document-icon">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>

                                        <span>
                                            {{ $payment->document?->title ?? 'Document supprimé' }}
                                        </span>

                                    </div>

                                </td>

                                <td>

                                    <strong class="amount">

                                        {{ number_format($payment->amount ?? 0, 0, ',', ' ') }}

                                        <small>
                                            FCFA
                                        </small>

                                    </strong>

                                </td>

                                <td>

                                    <span class="status-badge status-success">

                                        <i class="fas fa-check-circle"></i>

                                        Payé

                                    </span>

                                </td>

                                <td>

                                    {{ optional($payment->created_at)->format('d/m/Y H:i') }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            <div class="pagination-container">

                {{ $payments->links() }}

            </div>

        @endif

    </div>

</div>

@endsection