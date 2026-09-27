<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attestation de Travail - {{ $sollicitation->agent->nom_prenom_agent }}</title>
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
        line-height: 1.6;
    }

    .header-left .underline {
        text-decoration: underline;
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
        margin: 10px 0 4px 0;
    }

    .logo-section img {
        width: 70px;
        height: 70px;
        object-fit: contain;
    }

    .logo-section .secretariat {
        font-size: 10pt;
        font-weight: bold;
        margin-top: 4px;
    }

    .logo-section .services {
        font-size: 10pt;
        
    }

    /* ── Numéro ── */
    .numero {
        font-size: 11pt;
        margin: 14px 0 20px 0;
    }

    /* ── Séparateur ── */
    .separator {
        border: none;
        border-top: 1px solid #000;
        margin: 6px 0 18px 0;
    }

    /* ── Titre ── */
    .titre {
        text-align: center;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
        text-transform: uppercase;
        margin-bottom: 24px;
        letter-spacing: 1px;
    }

    /* ── Corps du document ── */
    .body-text {
        font-size: 11.5pt;
        line-height: 2;
        text-align: justify;
    }

    .body-text p {
        margin-bottom: 6px;
    }

    .field {
        display: inline-block;
        min-width: 120px;
        border-bottom: 1px solid #000;
        font-weight: bold;
    }

    .field-long {
        display: inline-block;
        min-width: 220px;
        border-bottom: 1px solid #000;
        font-weight: bold;
    }

    /* ── Signature ── */
    .signature-section {
        margin-top: 30px;
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
        margin-top: 40px;
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
    }
    </style>
</head>

<body>
    {{-- ══ CORPS ══ --}}
    @php
    $agent = $sollicitation->agent;
    $commune = $agent->commune;
    $bareme = $agent->baremeSalarial;
    $dateNaiss = $agent->date_naissance_agent
    ? \Carbon\Carbon::parse($agent->date_naissance_agent)->locale('fr')->isoFormat('DD MMMM YYYY')
    : '_______________';
    $dateEmbauche = $agent->date_embauche
    ? \Carbon\Carbon::parse($agent->date_embauche)->locale('fr')->isoFormat('DD MMMM YYYY')
    : '_______________';
    $datePrise = $agent->date_prise_service
    ? \Carbon\Carbon::parse($agent->date_prise_service)->locale('fr')->isoFormat('DD MMMM YYYY')
    : '_______________';
    $dateDoc = \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd DD MMMM YYYY');
    $retraite = $agent->date_embauche
    ? \Carbon\Carbon::parse($agent->date_embauche)->addYears(35)->locale('fr')->isoFormat('DD MMMM YYYY')
    : '_______________';

    // Calcul ancienneté
   $diff = $agent->date_prise_service
    ? \Carbon\Carbon::parse($agent->date_prise_service)->diff(\Carbon\Carbon::now())
    : null;

$anneesService = $diff
    ? ($diff->y > 0
        ? $diff->y . ' an' . ($diff->y > 1 ? 's' : '') . ' et ' . $diff->m . ' mois'
        : $diff->m . ' mois')
    : '___';

    // Civilité
    $civilite = $agent->sexe_agent === 'F' ? 'Mme/Mlle' : 'M';
    @endphp

    {{-- ══ EN-TÊTE ══ --}}
    <div class="header">
        <div class="header-left">
            <div>DEPARTEMENT DE {{ Str::upper($agent->commune->nom_commune ?? 'NOM DE LA COMMUNE') }}</div>
            <div style="margin-left: 30px;">-------------------------</div>
            <div class="">COMMUNE DE {{ Str::upper($agent->commune->nom_commune ?? 'NOM DE LA COMMUNE') }}
            </div>
        </div>
        <div class="header-right">
            <div class="bold">REPUBLIQUE DE COTE D'IVOIRE</div>
            <div class="italic">Union-Discipline-Travail</div>
            <div>-----------</div>
        </div>
    </div>

    {{-- Logo + Secrétariat --}}
    <div class="logo-section">
        <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo Mairie">
        <div class="secretariat">SECRETARIAT GENERAL</div>
        <div class="services">Services Administratifs</div>
        <div style="margin-left: 50px;">-----------</div>
    </div>

    {{-- Numéro --}}
    <div class="numero">
        N° &nbsp;&nbsp;&nbsp; /_____ /COM-KKRO/SG/SA
    </div>

    {{-- Séparateur --}}

    {{-- ══ TITRE ══ --}}
    <div class="titre">ATTESTATION DE TRAVAIL</div>

    

    <div class="body-text">

        <p><strong>Le Maire de la Commune soussigné, atteste que :</strong></p>

        <p>{{ $civilite }}
            <span class="field-long">{{ $agent->nom_prenom_agent ?? '_______________' }}</span>
        </p>

        <p>
            Matricule :
            <span class="field">{{ $agent->matricule ?? '_______________' }}</span>
        </p>

        <p>
            né(e) le
            <span class="field">{{ $dateNaiss }}</span>
            , entré(e) à la Fonction Publique le
            <span class="field">{{ $dateEmbauche }}</span>
            , qui totalise au
        </p>

        <p>
            <span class="field">{{ $anneesService }}</span>
            de service effectif, qui sera appelé(e) à faire valoir ses droits à la retraite pour limite d'âge le
            <span class="field-long">{{ $retraite }}</span>
        </p>

        <p>
            et qui est mis à la disposition de la Commune de {{ $agent->commune->nom_commune ?? '_______________' }} par
            arrêté du Maire en date du
        </p>

        <p>
            pour y servir en qualité de
            <span class="field-long">{{ $agent->fonction ?? '_______________' }}</span>
        </p>

        <p>
            Est en fonction à la Mairie de {{ $agent->commune->nom_commune ?? '_______________' }} depuis le
            <span class="field">{{ $datePrise }}</span>
            , date de sa prise de service.
        </p>

        <p style="margin-top: 16px;">
            En foi de quoi, la présente Attestation est établis pour servir et valoir ce que de droit.-
        </p>

    </div>

    {{-- ══ SIGNATURE ══ --}}
    <div class="signature-section">
        <div class="lieu-date">{{ $agent->commune->nom_commune ?? 'NOM DE LA COMMUNE' }}, le {{ $dateDoc }}</div>
        <div class="signataire">
            &nbsp; {{ $sollicitation->fonction_signataire ?? 'PD' }}
        </div>

        <div style="margin-top: 10px; font-size: 11pt;">
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

    {{-- Bouton impression (masqué à l'impression) --}}
    <div style="text-align:center; margin-top:30px;" class="no-print">
        <button onclick="window.print()" style="padding: 10px 30px; background: #0B1F3A; color: white;
                       border: none; border-radius: 8px; font-size: 13px;
                       cursor: pointer; font-family: sans-serif;">
            🖨️ Imprimer ce document
        </button>
    </div>

    <style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
    </style>

</body>

</html>