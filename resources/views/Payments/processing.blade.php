@extends('layouts.app')

@section('title', 'Paiement en cours')

@section('content')

@php
    $status = $payment->status;

    $methodLabels = [
        'orange_money' => 'Orange Money',
        'moov_money' => 'Moov Money',
        'mtn_money' => 'MTN Mobile Money',
        'card' => 'Carte bancaire',
    ];

    $methodLabel = $methodLabels[$payment->payment_method] ?? $payment->payment_method;

    $isPending = $status === 'pending';
    $isPaid = $status === 'paid';
    $isFailed = $status === 'failed';
    $isCancelled = $status === 'cancelled';
@endphp

<div class="payment-status-page">
    <div
        class="payment-status-card
        {{ $isPaid ? 'status-paid' : '' }}
        {{ $isFailed ? 'status-failed' : '' }}
        {{ $isCancelled ? 'status-cancelled' : '' }}"
        id="paymentStatusCard"
    >

        {{-- ============================================================= --}}
        {{-- ICÔNE DE STATUT --}}
        {{-- ============================================================= --}}

        <div class="processing-icon">

            @if($isPending)

                <div class="spinner"></div>
                <i class="bi bi-phone-fill"></i>

            @elseif($isPaid)

                <i class="bi bi-check-circle-fill"></i>

            @elseif($isFailed)

                <i class="bi bi-x-circle-fill"></i>

            @elseif($isCancelled)

                <i class="bi bi-slash-circle-fill"></i>

            @endif

        </div>

        {{-- ============================================================= --}}
        {{-- BADGE --}}
        {{-- ============================================================= --}}

        @if($isPending)

            <span class="status-badge status-pending">
                <i class="bi bi-hourglass-split"></i>
                PAIEMENT EN COURS
            </span>

        @elseif($isPaid)

            <span class="status-badge status-success">
                <i class="bi bi-check-circle-fill"></i>
                PAIEMENT CONFIRMÉ
            </span>

        @elseif($isFailed)

            <span class="status-badge status-danger">
                <i class="bi bi-x-circle-fill"></i>
                PAIEMENT ÉCHOUÉ
            </span>

        @elseif($isCancelled)

            <span class="status-badge status-cancelled">
                <i class="bi bi-slash-circle-fill"></i>
                PAIEMENT ANNULÉ
            </span>

        @endif

        {{-- ============================================================= --}}
        {{-- TITRE --}}
        {{-- ============================================================= --}}

        @if($isPending)

            <h1>Traitement de votre paiement</h1>

            <p class="status-description">
                Votre demande de paiement a bien été enregistrée.
                Veuillez patienter pendant la confirmation de la transaction.
            </p>

        @elseif($isPaid)

            <h1>Paiement confirmé</h1>

            <p class="status-description">
                Votre paiement a été confirmé avec succès.
                Vous pouvez maintenant accéder à votre document premium.
            </p>

        @elseif($isFailed)

            <h1>Paiement échoué</h1>

            <p class="status-description">
                Nous n'avons pas pu confirmer votre paiement.
                Vous pouvez vérifier les informations de la transaction
                ou recommencer le paiement.
            </p>

        @elseif($isCancelled)

            <h1>Paiement annulé</h1>

            <p class="status-description">
                Cette demande de paiement a été annulée.
                Aucun accès premium n'a été accordé.
            </p>

        @endif

        {{-- ============================================================= --}}
        {{-- INFORMATIONS DU PAIEMENT --}}
        {{-- ============================================================= --}}

        <div class="payment-info">

            {{-- DOCUMENT --}}

            <div class="payment-info-row">

                <span>
                    <i class="bi bi-file-earmark-text"></i>
                    Document
                </span>

                <strong>
                    {{ $payment->document->title }}
                </strong>

            </div>

            {{-- MONTANT --}}

            <div class="payment-info-row">

                <span>
                    <i class="bi bi-cash-stack"></i>
                    Montant
                </span>

                <strong>
                    {{ number_format($payment->amount, 0, ',', ' ') }}
                    {{ $payment->currency }}
                </strong>

            </div>

            {{-- MOYEN --}}

            <div class="payment-info-row">

                <span>
                    <i class="bi bi-wallet2"></i>
                    Moyen
                </span>

                <strong>
                    {{ $methodLabel }}
                </strong>

            </div>

            {{-- NUMÉRO --}}

            @if($payment->phone)

                <div class="payment-info-row">

                    <span>
                        <i class="bi bi-phone"></i>
                        Numéro
                    </span>

                    <strong>
                        +226 {{ $payment->phone }}
                    </strong>

                </div>

            @endif

            {{-- RÉFÉRENCE --}}

            @if($payment->payment_reference)

                <div class="payment-info-row">

                    <span>
                        <i class="bi bi-hash"></i>
                        Référence
                    </span>

                    <strong>
                        {{ $payment->payment_reference }}
                    </strong>

                </div>

            @endif

            {{-- TRANSACTION --}}

            @if($payment->transaction_id)

                <div class="payment-info-row">

                    <span>
                        <i class="bi bi-receipt"></i>
                        Transaction
                    </span>

                    <strong>
                        {{ $payment->transaction_id }}
                    </strong>

                </div>

            @endif

            {{-- DATE DE PAIEMENT --}}

            @if($payment->paid_at)

                <div class="payment-info-row">

                    <span>
                        <i class="bi bi-calendar-check"></i>
                        Date de paiement
                    </span>

                    <strong>
                        {{ $payment->paid_at->format('d/m/Y à H:i') }}
                    </strong>

                </div>

            @endif

        </div>

        {{-- ============================================================= --}}
        {{-- MESSAGE PENDING --}}
        {{-- ============================================================= --}}

        @if($isPending)

            <div class="waiting-box">

                <i class="bi bi-info-circle-fill"></i>

                <div>

                    <strong>
                        Confirmez le paiement sur votre téléphone
                    </strong>

                    <p>
                        Si une demande de confirmation apparaît sur votre
                        téléphone, veuillez l'accepter.
                    </p>

                    <p class="waiting-small">
                        Cette page vérifie automatiquement l'état de votre
                        paiement.
                    </p>

                </div>

            </div>

        @endif

        {{-- ============================================================= --}}
        {{-- MESSAGE SUCCÈS --}}
        {{-- ============================================================= --}}

        @if($isPaid)

            <div class="result-box result-success">

                <i class="bi bi-check-circle-fill"></i>

                <div>

                    <strong>
                        Accès autorisé
                    </strong>

                    <p>
                        Votre paiement est confirmé.
                        Votre accès au document premium est maintenant actif.
                    </p>

                </div>

            </div>

        @endif

        {{-- ============================================================= --}}
        {{-- MESSAGE ÉCHEC --}}
        {{-- ============================================================= --}}

        @if($isFailed)

            <div class="result-box result-danger">

                <i class="bi bi-exclamation-triangle-fill"></i>

                <div>

                    <strong>
                        Le paiement n'a pas abouti
                    </strong>

                    <p>

                        @if($payment->failure_reason)
                            {{ $payment->failure_reason }}
                        @else
                            La transaction n'a pas pu être confirmée.
                        @endif

                    </p>

                </div>

            </div>

        @endif

        {{-- ============================================================= --}}
        {{-- MESSAGE ANNULATION --}}
        {{-- ============================================================= --}}

        @if($isCancelled)

            <div class="result-box result-cancelled">

                <i class="bi bi-info-circle-fill"></i>

                <div>

                    <strong>
                        Transaction annulée
                    </strong>

                    <p>
                        Vous pouvez retourner au document et recommencer
                        le paiement si vous le souhaitez.
                    </p>

                </div>

            </div>

        @endif

        {{-- ============================================================= --}}
        {{-- ACTIONS --}}
        {{-- ============================================================= --}}

        <div class="processing-actions">

            @if($isPending)

                <button
                    type="button"
                    class="status-link"
                    id="checkStatusButton"
                >
                    <i class="bi bi-arrow-clockwise"></i>
                    Vérifier le statut
                </button>

                <form
                    action="{{ route('payments.cancel', ['payment' => $payment->id]) }}"
                    method="POST"
                    class="cancel-form"
                >

                    @csrf

                    <button
                        type="submit"
                        class="cancel-link"
                        onclick="return confirm('Voulez-vous vraiment annuler ce paiement ?')"
                    >
                        <i class="bi bi-x-lg"></i>
                        Annuler
                    </button>

                </form>

            @elseif($isPaid)

                <a
                    href="{{ route('documents.show', ['document' => $payment->document->id]) }}"
                    class="access-button"
                >
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                    Accéder au document
                </a>

            @elseif($isFailed || $isCancelled)

                <a
                    href="{{ route('payments.create', ['document' => $payment->document->id]) }}"
                    class="retry-button"
                >
                    <i class="bi bi-arrow-repeat"></i>
                    Recommencer le paiement
                </a>

                <a
                    href="{{ route('documents.show', ['document' => $payment->document->id]) }}"
                    class="back-button"
                >
                    <i class="bi bi-arrow-left"></i>
                    Retour au document
                </a>

            @endif

        </div>

        {{-- ============================================================= --}}
        {{-- SÉCURITÉ --}}
        {{-- ============================================================= --}}

        <div class="footer-security">

            <i class="bi bi-shield-lock-fill"></i>

            <span>
                Paiement sécurisé par Scientia
            </span>

        </div>

    </div>
</div>

<style>
.payment-status-page{
    min-height:calc(100vh - 80px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:50px 20px;
    background:
        radial-gradient(
            circle at top left,
            rgba(37,99,235,.08),
            transparent 35%
        ),
        linear-gradient(135deg,#f8fafc,#eef4ff);
}

.payment-status-card{
    width:100%;
    max-width:620px;
    padding:45px 40px;
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:25px;
    text-align:center;
    box-shadow:0 20px 50px rgba(15,23,42,.10);
}

.processing-icon{
    position:relative;
    width:95px;
    height:95px;
    margin:0 auto 22px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:#eff6ff;
    color:#2563eb;
    font-size:30px;
}

.spinner{
    position:absolute;
    inset:-6px;
    border:4px solid #dbeafe;
    border-top-color:#2563eb;
    border-radius:50%;
    animation:payment-spin 1s linear infinite;
}

@keyframes payment-spin{
    to{
        transform:rotate(360deg);
    }
}

.status-paid .processing-icon{
    background:#f0fdf4;
    color:#16a34a;
}

.status-failed .processing-icon{
    background:#fef2f2;
    color:#dc2626;
}

.status-cancelled .processing-icon{
    background:#f8fafc;
    color:#64748b;
}

.status-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:7px 13px;
    border-radius:30px;
    font-size:11px;
    font-weight:800;
    letter-spacing:.5px;
}

.status-pending{
    background:#eff6ff;
    color:#2563eb;
}

.status-success{
    background:#f0fdf4;
    color:#15803d;
}

.status-danger{
    background:#fef2f2;
    color:#b91c1c;
}

.status-cancelled{
    background:#f1f5f9;
    color:#475569;
}

.payment-status-card h1{
    margin:18px 0 10px;
    color:#0f172a;
    font-size:25px;
    font-weight:800;
}

.status-description{
    max-width:500px;
    margin:0 auto 28px;
    color:#64748b;
    font-size:14px;
    line-height:1.7;
}

.payment-info{
    text-align:left;
    padding:18px;
    border:1px solid #e2e8f0;
    border-radius:17px;
    background:#f8fafc;
}

.payment-info-row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    padding:12px 0;
    border-bottom:1px solid #e2e8f0;
}

.payment-info-row:last-child{
    border-bottom:0;
}

.payment-info-row span{
    display:flex;
    align-items:center;
    gap:8px;
    color:#64748b;
    font-size:13px;
}

.payment-info-row strong{
    max-width:55%;
    color:#0f172a;
    font-size:13px;
    text-align:right;
    word-break:break-word;
}

.waiting-box,
.result-box{
    display:flex;
    align-items:flex-start;
    gap:12px;
    margin-top:20px;
    padding:17px;
    border-radius:15px;
    text-align:left;
}

.waiting-box{
    border:1px solid #bfdbfe;
    background:#eff6ff;
    color:#1e40af;
}

.waiting-box>i,
.result-box>i{
    margin-top:2px;
    font-size:20px;
}

.waiting-box strong,
.result-box strong{
    display:block;
    margin-bottom:4px;
}

.waiting-box p,
.result-box p{
    margin:0;
    color:#475569;
    font-size:12px;
    line-height:1.6;
}

.waiting-small{
    margin-top:7px!important;
    color:#64748b!important;
}

.result-success{
    border:1px solid #bbf7d0;
    background:#f0fdf4;
    color:#15803d;
}

.result-danger{
    border:1px solid #fecaca;
    background:#fef2f2;
    color:#b91c1c;
}

.result-cancelled{
    border:1px solid #cbd5e1;
    background:#f8fafc;
    color:#475569;
}

.processing-actions{
    display:flex;
    align-items:center;
    justify-content:center;
    flex-wrap:wrap;
    gap:10px;
    margin-top:25px;
}

.status-link,
.cancel-link,
.access-button,
.retry-button,
.back-button{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    min-height:44px;
    padding:12px 20px;
    border-radius:12px;
    font-size:13px;
    font-weight:700;
    text-decoration:none;
    cursor:pointer;
    transition:.2s ease;
}

.status-link{
    border:1px solid #dbeafe;
    color:#2563eb;
    background:#fff;
}

.status-link:hover{
    background:#eff6ff;
    transform:translateY(-1px);
}

.cancel-form{
    margin:0;
}

.cancel-link{
    border:1px solid #fecaca;
    color:#dc2626;
    background:#fff;
}

.cancel-link:hover{
    background:#fef2f2;
}

.access-button{
    width:100%;
    border:0;
    background:linear-gradient(135deg,#16a34a,#15803d);
    color:#fff;
    box-shadow:0 10px 25px rgba(22,163,74,.20);
}

.access-button:hover{
    color:#fff;
    transform:translateY(-2px);
}

.retry-button{
    border:0;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
}

.retry-button:hover{
    color:#fff;
    transform:translateY(-1px);
}

.back-button{
    border:1px solid #e2e8f0;
    color:#475569;
    background:#fff;
}

.back-button:hover{
    background:#f8fafc;
}

.footer-security{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    margin-top:25px;
    color:#64748b;
    font-size:12px;
}

.footer-security i{
    color:#2563eb;
}

@media(max-width:600px){

    .payment-status-page{
        padding:25px 12px;
    }

    .payment-status-card{
        padding:32px 20px;
        border-radius:20px;
    }

    .payment-status-card h1{
        font-size:21px;
    }

    .payment-info-row{
        align-items:flex-start;
        flex-direction:column;
        gap:5px;
    }

    .payment-info-row strong{
        max-width:100%;
        text-align:left;
    }

    .processing-actions{
        flex-direction:column;
    }

    .status-link,
    .cancel-link,
    .access-button,
    .retry-button,
    .back-button{
        width:100%;
    }
}
</style>

@if($isPending)

<script>
document.addEventListener('DOMContentLoaded', function () {

    const statusUrl = @json(
        route('payments.status', ['payment' => $payment->id])
    );

    const documentUrl = @json(
        route('documents.show', ['document' => $payment->document->id])
    );

    const checkButton = document.getElementById('checkStatusButton');

    let checking = false;

    async function checkPaymentStatus() {

        if (checking) {
            return;
        }

        checking = true;

        if (checkButton) {
            checkButton.disabled = true;
            checkButton.innerHTML =
                '<i class="bi bi-arrow-repeat"></i> Vérification...';
        }

        try {

            const response = await fetch(statusUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error('Erreur lors de la vérification.');
            }

            const data = await response.json();

            if (data.paid === true || data.status === 'paid') {

                window.location.href = documentUrl;

                return;
            }

            if (
                data.status === 'failed' ||
                data.status === 'cancelled'
            ) {

                window.location.reload();

                return;
            }

        } catch (error) {

            console.error(
                'Erreur vérification paiement :',
                error
            );

        } finally {

            checking = false;

            if (checkButton) {
                checkButton.disabled = false;
                checkButton.innerHTML =
                    '<i class="bi bi-arrow-clockwise"></i> Vérifier le statut';
            }
        }
    }

    if (checkButton) {
        checkButton.addEventListener(
            'click',
            checkPaymentStatus
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION AUTOMATIQUE
    |--------------------------------------------------------------------------
    |
    | Toutes les 5 secondes.
    |
    */

    setInterval(
        checkPaymentStatus,
        5000
    );

});
</script>

@endif

@endsection