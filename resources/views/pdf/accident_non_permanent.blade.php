<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accident de Travail - {{ $sollicitation->agentNonPermanent->nom_prenom_nopermanent }}</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: "Times New Roman", Times, serif;
        font-size: 12pt;
        color: #000;
        background: #fff;
        padding: 20px 40px;
    }

    /* ── En-tête ── */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
    }

    .header-left {
        font-size: 10pt;
        font-weight: bold;
        line-height: 1.8;
    }

    .header-left .underline {
        text-decoration: underline;
    }

    .header-left .indent {
        padding-left: 20px;
    }

    .header-right {
        font-size: 10pt;
        text-align: right;
        line-height: 1.6;
    }

    .header-right .bold {
        font-weight: bold;
    }

    .header-right .italic {
        font-style: italic;
    }

    /* ── Logo ── */
    .logo-section {
        margin: 8px 0 4px 20px;
    }

    .logo-section img {
        width: 70px;
        height: 70px;
        object-fit: contain;
    }

    /* ── Numéro ── */
    .numero {
        font-size: 11pt;
        margin: 16px 0 20px 0;
    }

    /* ── Titre ── */
    .titre {
        font-size: 13pt;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 20px;
        letter-spacing: 1px;
    }

    /* ── Corps ── */
    .content-wrap {
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }

    .body-text {
        flex: 1;
        font-size: 11pt;
        line-height: 1.95;
    }

    .body-text p {
        margin-bottom: 2px;
    }

    /* Photo */
    .photo-box {
        width: 90px;
        height: 110px;
        border: 1px solid #000;
        flex-shrink: 0;
        margin-top: 4px;
    }

    .row {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-bottom: 2px;
        flex-wrap: wrap;
    }

    .label {
        font-weight: bold;
        white-space: nowrap;
    }

    .field {
        display: inline-block;
        min-width: 100px;
        border-bottom: 1px solid #000;
        font-weight: bold;
    }

    .field-long {
        display: inline-block;
        min-width: 200px;
        border-bottom: 1px solid #000;
        font-weight: bold;
    }

    .field-xl {
        display: inline-block;
        min-width: 280px;
        border-bottom: 1px solid #000;
        font-weight: bold;
    }

    /* ── Signature ── */
    .signature-section {
        margin-top: 28px;
        text-align: center;
    }

    .signature-section .lieu-date {
        font-size: 11pt;
        margin-bottom: 6px;
    }

    .signature-section .signataire {
        font-size: 11pt;
        font-weight: bold;
    }

    /* ── Ampliations ── */
    .ampliations {
        margin-top: 3px;
        font-size: 10pt;
    }

    .ampliations .titre-ampl {
        font-weight: bold;
        text-decoration: underline;
        margin-bottom: 4px;
    }

    .ampliations ul {
        list-style: none;
        padding-left: 10px;
        line-height: 1.8;
    }

    @media print {
        body {
            padding: 10px 30px;
        }

        @page {
            size: A4;
            margin: 15mm 20mm;
        }

        .no-print {
            display: none !important;
        }
    }
    </style>
</head>

<body>

    @php
    $agent = $sollicitation->agentNonPermanent;
    $commune = $agent->commune;
    $nomCommune = $commune?->nom_commune ?? 'Bonoua';

    // Dates
    $dateNaiss = $agent->date_naissance_nopermanent ?? null;
    $dateNaissF = $dateNaiss
    ? \Carbon\Carbon::parse($dateNaiss)->locale('fr')->isoFormat('DD MMMM YYYY')
    : '_______________';

    $dateAccident = $sollicitation->date_accident
    ? \Carbon\Carbon::parse($sollicitation->date_accident)->locale('fr')->isoFormat('DD MMMM YYYY')
    : '_______________';

    $dateCnps = $sollicitation->date_declare_cnps
    ? \Carbon\Carbon::parse($sollicitation->date_declare_cnps)->locale('fr')->isoFormat('DD MMMM YYYY')
    : '_______________';

    $dateDoc = \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd DD MMMM YYYY');
    @endphp

    {{-- ══ EN-TÊTE ══ --}}
    <div class="header">
        <div class="header-left">
            <div>DEPARTEMENT DE {{ Str::upper($nomCommune) }}</div>
            <div class="">COMMUNE DE {{ Str::upper($nomCommune) }}</div>
        </div>
        <div class="header-right">
            <div class="bold">REPUBLIQUE DE COTE D'IVOIRE</div>
            <div class="italic">Union-Discipline-Travail</div>
            <div>------------</div>
        </div>
    </div>

    {{-- Logo --}}
    <div class="logo-section">
        <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo Mairie">
        <div class="secretariat">SECRETARIAT GENERAL</div>
        <div class="services">Services Administratifs</div>
        <div style="margin-left: 50px;">-----------</div>
    </div>

    {{-- Numéro --}}
    <div class="numero">
        N° &nbsp;&nbsp;&nbsp;&nbsp; /_____ / CB/SG/SA
    </div>

    {{-- ══ TITRE ══ --}}
    <div class="titre">ACCIDENT SURVENU AU COURS DU TRAVAIL</div>

    {{-- ══ CORPS + PHOTO ══ --}}
    <div class="content-wrap">
        <div class="body-text">

            <div class="row">
                <span class="label">Prénoms et Nom :</span>
                <span class="field-xl">{{ $agent->nom_prenom_nopermanent ?? '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">Matricule :</span>
                <span class="field">{{ $agent->numero_act_recrutement_nopermanents ?? '' }}</span>
                &nbsp;&nbsp;
                <span class="label">Catégorie :</span>
                <span class="field">{{ $agent->statut_nopermanents ?? ' ' }}</span>
            </div>

            <div class="row">
                <span class="label">Services :</span>
                <span class="field-long">{{ $agent->service_nopermanent ?? '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">Fonction :</span>
                <span class="field-long">{{ $agent->fonction_nopermanent ?? '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">Né(e) le :</span>
                <span class="field">{{ $dateNaissF }}</span>
                &nbsp;&nbsp;
                <span class="label">Situation maritale</span>
                <span class="field">{{ $agent->situa_marial_nopermanent ?? '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">N° Acte de recrutement :</span>
                <span class="field-long">{{ $agent->act_recrutement_nopermanent ?? '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">N° CNPS</span>
                <span class="field">{{ $agent->numero_cnps_agentnopermanent ?? '_______________' }}</span>
                &nbsp;&nbsp;
                <span class="label">Contacts :</span>
                <span class="field">{{ $agent->contact_agent_nopermanent ?? '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">N° Pièce d'identité :</span>
                <span class="field">{{ $agent->numero_piece_agentnopermanent ?? '_______________' }}</span>
                &nbsp;&nbsp;
                <span class="label">Etablie le :</span>
                <span class="field">
                    {{ $agent->date_piece_etabli_agentnopermanent
            ? \Carbon\Carbon::parse($agent->date_piece_etabli_agentnopermanent)->locale('fr')->isoFormat('DD/MM/YYYY')
            : '_______________' }}
                </span>
            </div>

            <div class="row">
                <span class="label">Date de l'accident</span>
                <span class="field">{{ $dateAccident }}</span>
                &nbsp;&nbsp;
                <span class="label">Lieu de l'accident :</span>
                <span class="field">{{ $sollicitation->lieu_accident ?? '_______________' }}</span>
            </div>

            <p style="margin-top: 8px;">
                <span class="label">Circonstance de l'accident</span>
            </p>
            <p><span class="field-xl">&nbsp;</span></p>

            <div class="row">
                <span class="label">Accident déclaré sous le N° :</span>
                <span class="field-long">_______________</span>
            </div>

            <div class="row">
                <span class="label">Déclaré à la CNPS le :</span>
                <span class="field-long">{{ $sollicitation->declare_cnps ? $dateCnps : '_______________' }}</span>
            </div>

            <div class="row">
                <span class="label">Gravité de l'accident :</span>
                <span class="field-long">{{ $sollicitation->gravite_accident ?? '_______________' }}</span>
            </div>

        </div>

        {{-- Photo --}}
        <div class="photo-box">
            @if($agent->photo_agent_nopermanent)
            <img src="{{ Storage::url($agent->photo_agent_nopermanent) }}" alt="Photo agent"
                style="width:100%; height:100%; object-fit:cover;">
            @endif
        </div>
    </div>

    {{-- ══ SIGNATURE ══ --}}
    <div class="signature-section">
        <div class="lieu-date">{{ $nomCommune }}, le {{ $dateDoc }}</div>
        <div class="signataire">
            {{ $sollicitation->fonction_signataire ?? 'PD' }}
        </div>
        <div style="margin-top: 5px; font-size: 11pt;">
            {{ $sollicitation->signataire ?? '' }}
        </div>
    </div>

    {{-- ══ AMPLIATIONS ══ --}}
    <div class="ampliations">
        <div class="titre-ampl">Ampliations</div>
        <ul>
            <li>Intéressé(e)——————————1</li>
            <li>Dossier————————————1</li>
            <li>Chrono————————————1</li>
        </ul>
    </div>

    {{-- Bouton impression --}}
    <div style="text-align:center; margin-top:30px;" class="no-print">
        <button onclick="window.print()" style="padding: 10px 30px; background: #0B1F3A; color: white;
                       border: none; border-radius: 8px; font-size: 13px;
                       cursor: pointer; font-family: sans-serif;">
            🖨️ Imprimer ce document
        </button>
    </div>

</body>

</html>