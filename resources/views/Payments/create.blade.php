@extends('layouts.app')

@section('title', 'Paiement sécurisé')

@section('content')

<div class="payment-page">
    <div class="payment-container">


    {{-- HEADER --}}
    <div class="payment-header">
        <div class="payment-security-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <div>
            <h1>Paiement sécurisé</h1>
            <p>
                Effectuez votre paiement pour accéder au document premium.
            </p>
        </div>
    </div>

    {{-- ALERTES --}}
    @if(session('error'))
        <div class="payment-alert payment-alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="payment-alert payment-alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>

            <div>
                <strong>Veuillez vérifier les informations.</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- DOCUMENT --}}
    <div class="payment-card">

        <div class="document-preview">
            @if($document->cover_image)
                <img
                    src="{{ asset('storage/' . $document->cover_image) }}"
                    alt="{{ $document->title }}"
                >
            @else
                <div class="document-placeholder">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                </div>
            @endif
        </div>

        <div class="document-info">

            <span class="premium-badge">
                <i class="bi bi-star-fill"></i>
                DOCUMENT PREMIUM
            </span>

            <h2>{{ $document->title }}</h2>

            @if($document->description)
                <p>{{ $document->description }}</p>
            @endif

            <div class="document-meta">

                @if($document->documentType)
                    <span>
                        <i class="bi bi-file-text"></i>
                        {{ $document->documentType->name }}
                    </span>
                @endif

                <span>
                    <i class="bi bi-file-earmark-pdf"></i>
                    PDF
                </span>

                @if($document->file_size)
                    <span>
                        <i class="bi bi-hdd"></i>
                        {{ number_format($document->file_size / 1024 / 1024, 2, ',', ' ') }} Mo
                    </span>
                @endif

            </div>

        </div>
    </div>

    {{-- PRIX --}}
    <div class="price-section">

        <div>
            <span class="price-label">
                Montant à payer
            </span>

            <span class="price-note">
                Paiement unique
            </span>
        </div>

        <div class="price-value">
            <strong>
                {{ number_format($document->price, 0, ',', ' ') }}
            </strong>

            <span>FCFA</span>
        </div>

    </div>

    {{-- FORMULAIRE --}}
    <form
        action="{{ route('payments.store', ['document' => $document->id]) }}"
        method="POST"
        id="paymentForm"
    >

        @csrf

        {{-- MOYEN DE PAIEMENT --}}
        <div class="form-section">

            <div class="section-title">

                <div class="section-number">
                    1
                </div>

                <div>
                    <h3>Choisissez votre moyen de paiement</h3>

                    <p>
                        Sélectionnez le service Mobile Money que vous souhaitez utiliser.
                    </p>
                </div>

            </div>

            <div class="payment-methods">

                {{-- ORANGE MONEY --}}
                <label class="payment-method">

                    <input
                        type="radio"
                        name="payment_method"
                        value="orange_money"
                        {{ old('payment_method') === 'orange_money' ? 'checked' : '' }}
                        required
                    >

                    <div class="method-content">

                        <div class="method-logo orange-logo">
                            <i class="bi bi-phone-fill"></i>
                        </div>

                        <div class="method-info">
                            <strong>Orange Money</strong>
                            <span>Paiement mobile Orange</span>
                        </div>

                        <div class="method-check">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                    </div>

                </label>

                {{-- MOOV MONEY --}}
                <label class="payment-method">

                    <input
                        type="radio"
                        name="payment_method"
                        value="moov_money"
                        {{ old('payment_method') === 'moov_money' ? 'checked' : '' }}
                        required
                    >

                    <div class="method-content">

                        <div class="method-logo moov-logo">
                            <i class="bi bi-phone-fill"></i>
                        </div>

                        <div class="method-info">
                            <strong>Moov Money</strong>
                            <span>Paiement mobile Moov</span>
                        </div>

                        <div class="method-check">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                    </div>

                </label>

            </div>
        </div>

        {{-- NUMÉRO --}}
        <div class="form-section">

            <div class="section-title">

                <div class="section-number">
                    2
                </div>

                <div>
                    <h3>Numéro Mobile Money</h3>

                    <p>
                        Entrez le numéro qui sera utilisé pour le paiement.
                    </p>
                </div>

            </div>

            <div class="phone-input-wrapper">

                <span class="country-code">
                    +226
                </span>

                <input
                    type="tel"
                    name="phone"
                    id="phone"
                    class="phone-input"
                    value="{{ old('phone') }}"
                    placeholder="70 00 00 00"
                    inputmode="numeric"
                    autocomplete="tel"
                    maxlength="8"
                    required
                >

            </div>

            <small class="input-help">
                <i class="bi bi-info-circle"></i>
                Utilisez un numéro Orange Money ou Moov Money actif.
            </small>

        </div>

        {{-- SÉCURITÉ --}}
        <div class="security-box">

            <i class="bi bi-shield-check"></i>

            <div>

                <strong>Paiement sécurisé</strong>

                <p>
                    Votre paiement sera traité de manière sécurisée.
                    L'accès au document sera accordé uniquement après confirmation du paiement.
                </p>

            </div>

        </div>

        {{-- BOUTON --}}
        <button
            type="submit"
            class="payment-submit"
            id="paymentSubmit"
        >

            <i class="bi bi-lock-fill"></i>

            <span>
                Continuer vers le paiement
            </span>

            <i class="bi bi-arrow-right"></i>

        </button>

    </form>

    {{-- RETOUR --}}
    <div class="payment-footer">

        <a href="{{ url()->previous() }}">
            <i class="bi bi-arrow-left"></i>
            Retour au document
        </a>

        <div class="footer-security">
            <i class="bi bi-shield-lock"></i>
            Paiement sécurisé
        </div>

    </div>

</div>
 
</div>

<style>
.payment-page{
    min-height:calc(100vh - 80px);
    background:radial-gradient(circle at top left,rgba(37,99,235,.08),transparent 35%),linear-gradient(135deg,#f8fafc,#eef4ff);
    padding:50px 20px;
}
.payment-container{
    width:100%;
    max-width:850px;
    margin:auto;
}
.payment-header{
    display:flex;
    align-items:center;
    gap:18px;
    background:linear-gradient(135deg,#0f3d91,#2563eb);
    color:#fff;
    padding:28px 32px;
    border-radius:24px 24px 0 0;
    box-shadow:0 15px 40px rgba(15,61,145,.18);
}
.payment-security-icon{
    width:55px;
    height:55px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:16px;
    background:rgba(255,255,255,.15);
    font-size:25px;
}
.payment-header h1{
    margin:0;
    font-size:25px;
    font-weight:800;
}
.payment-header p{
    margin:5px 0 0;
    color:#dbeafe;
    font-size:14px;
}
.payment-alert{
    display:flex;
    align-items:flex-start;
    gap:12px;
    margin-top:18px;
    padding:16px 18px;
    border-radius:14px;
    font-size:14px;
}
.payment-alert-danger{
    background:#fef2f2;
    border:1px solid #fecaca;
    color:#991b1b;
}
.payment-alert ul{
    margin:8px 0 0;
    padding-left:18px;
}
.payment-card{
    display:flex;
    gap:24px;
    background:#fff;
    padding:28px;
    border:1px solid #e2e8f0;
    border-top:0;
    box-shadow:0 15px 40px rgba(15,23,42,.08);
}
.document-preview{
    width:150px;
    min-width:150px;
    height:190px;
    overflow:hidden;
    border-radius:15px;
    background:#f1f5f9;
}
.document-preview img{
    width:100%;
    height:100%;
    object-fit:cover;
}
.document-placeholder{
    width:100%;
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#dc2626;
    font-size:55px;
}
.document-info{
    flex:1;
}
.premium-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:6px 11px;
    border-radius:30px;
    background:#fff7ed;
    color:#ea580c;
    font-size:11px;
    font-weight:800;
    letter-spacing:.5px;
}
.document-info h2{
    margin:14px 0 8px;
    font-size:23px;
    line-height:1.3;
    color:#0f172a;
}
.document-info p{
    color:#64748b;
    line-height:1.7;
    margin-bottom:15px;
}
.document-meta{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
}
.document-meta span{
    display:inline-flex;
    align-items:center;
    gap:5px;
    font-size:12px;
    color:#64748b;
}
.price-section{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-top:20px;
    padding:24px 28px;
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(15,23,42,.05);
}
.price-label{
    display:block;
    color:#334155;
    font-weight:700;
}
.price-note{
    display:block;
    margin-top:4px;
    color:#94a3b8;
    font-size:12px;
}
.price-value{
    display:flex;
    align-items:baseline;
    gap:6px;
    color:#1d4ed8;
}
.price-value strong{
    font-size:32px;
    font-weight:900;
}
.price-value span{
    font-size:14px;
    font-weight:700;
}
.form-section{
    margin-top:22px;
    padding:28px;
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:20px;
}
.section-title{
    display:flex;
    gap:14px;
    margin-bottom:22px;
}
.section-number{
    width:35px;
    height:35px;
    min-width:35px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    background:#eff6ff;
    color:#2563eb;
    font-weight:800;
}
.section-title h3{
    margin:0;
    font-size:16px;
    color:#0f172a;
}
.section-title p{
    margin:4px 0 0;
    font-size:13px;
    color:#64748b;
}
.payment-methods{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}
.payment-method{
    cursor:pointer;
}
.payment-method input{
    display:none;
}
.method-content{
    position:relative;
    display:flex;
    align-items:center;
    gap:14px;
    padding:18px;
    border:2px solid #e2e8f0;
    border-radius:16px;
    transition:.25s ease;
}
.payment-method:hover .method-content{
    border-color:#93c5fd;
    transform:translateY(-2px);
}
.payment-method input:checked+.method-content{
    border-color:#2563eb;
    background:#eff6ff;
    box-shadow:0 8px 25px rgba(37,99,235,.12);
}
.method-logo{
    width:48px;
    height:48px;
    min-width:48px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:13px;
    color:#fff;
    font-size:21px;
}
.orange-logo{
    background:#f97316;
}
.moov-logo{
    background:#16a34a;
}
.method-info{
    display:flex;
    flex-direction:column;
    gap:3px;
}
.method-info strong{
    color:#0f172a;
}
.method-info span{
    font-size:12px;
    color:#64748b;
}
.method-check{
    margin-left:auto;
    color:#2563eb;
    opacity:0;
    transition:.2s;
}
.payment-method input:checked+.method-content .method-check{
    opacity:1;
}
.phone-input-wrapper{
    display:flex;
    overflow:hidden;
    border:2px solid #e2e8f0;
    border-radius:14px;
    transition:.2s;
}
.phone-input-wrapper:focus-within{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.1);
}
.country-code{
    display:flex;
    align-items:center;
    padding:0 16px;
    background:#f8fafc;
    border-right:1px solid #e2e8f0;
    color:#475569;
    font-weight:700;
}
.phone-input{
    flex:1;
    border:0;
    outline:0;
    padding:15px;
    font-size:16px;
    color:#0f172a;
}
.input-help{
    display:block;
    margin-top:8px;
    color:#64748b;
    font-size:12px;
}
.security-box{
    display:flex;
    gap:14px;
    margin-top:22px;
    padding:18px;
    border-radius:16px;
    background:#f0fdf4;
    border:1px solid #bbf7d0;
    color:#166534;
}
.security-box>i{
    font-size:24px;
}
.security-box strong{
    display:block;
    margin-bottom:4px;
}
.security-box p{
    margin:0;
    font-size:12px;
    line-height:1.6;
    color:#4d7c5a;
}
.payment-submit{
    width:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    margin-top:22px;
    padding:17px 22px;
    border:0;
    border-radius:15px;
    background:linear-gradient(135deg,#ea580c,#dc2626);
    color:#fff;
    font-size:16px;
    font-weight:800;
    cursor:pointer;
    box-shadow:0 12px 30px rgba(220,38,38,.22);
    transition:.25s ease;
}
.payment-submit:hover{
    transform:translateY(-2px);
    box-shadow:0 16px 35px rgba(220,38,38,.28);
}
.payment-submit:active{
    transform:scale(.98);
}
.payment-submit:disabled{
    opacity:.7;
    cursor:not-allowed;
    transform:none;
}
.payment-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-top:20px;
    padding:0 5px;
}
.payment-footer a{
    display:inline-flex;
    align-items:center;
    gap:7px;
    color:#64748b;
    font-size:13px;
    text-decoration:none;
}
.payment-footer a:hover{
    color:#2563eb;
}
.footer-security{
    display:flex;
    align-items:center;
    gap:6px;
    color:#64748b;
    font-size:12px;
}
@media(max-width:700px){
    .payment-page{
        padding:25px 12px;
    }
    .payment-header{
        padding:22px;
        border-radius:18px 18px 0 0;
    }
    .payment-header h1{
        font-size:20px;
    }
    .payment-card{
        flex-direction:column;
        padding:20px;
    }
    .document-preview{
        width:100%;
        height:230px;
    }
    .payment-methods{
        grid-template-columns:1fr;
    }
    .price-section{
        padding:20px;
    }
    .price-value strong{
        font-size:25px;
    }
    .form-section{
        padding:20px;
    }
    .payment-footer{
        flex-direction:column;
        gap:12px;
        align-items:flex-start;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const form = document.getElementById('paymentForm');
    const button = document.getElementById('paymentSubmit');
    const phone = document.getElementById('phone');

    if (!form || !button || !phone) {
        return;
    }

    phone.addEventListener('input', function(){

        let value = this.value.replace(/\D/g, '');

        if (value.length > 8) {
            value = value.substring(0, 8);
        }

        this.value = value;
    });

    form.addEventListener('submit', function(event){

        const method = document.querySelector(
            'input[name="payment_method"]:checked'
        );

        if (!method) {
            event.preventDefault();

            alert('Veuillez sélectionner un moyen de paiement.');

            return;
        }

        if (phone.value.length !== 8) {
            event.preventDefault();

            alert('Veuillez saisir un numéro Mobile Money valide.');

            phone.focus();

            return;
        }

        button.disabled = true;

        button.querySelector('span').textContent =
            'Préparation du paiement...';
    });

});
</script>

@endsection
