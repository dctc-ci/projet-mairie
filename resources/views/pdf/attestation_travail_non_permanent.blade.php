<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attestation de Travail - {{ $sollicitation->agentNonPermanent->nom_prenom_nopermanent }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

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
        .header-left { font-size: 10pt; font-weight: bold; line-height: 1.6; }
        .header-left .underline { text-decoration: underline; }
        .header-right { font-size: 10pt; text-align: right; line-height: 1.6; }
        .header-right .bold   { font-weight: bold; }
        .header-right .italic { font-style: italic; }

        /* ── Logo ── */
        .logo-section { margin: 10px 0 4px 0; }
        .logo-section img { width: 70px; height: 70px; object-fit: contain; }
        .logo-section .secretariat { font-size: 10pt; font-weight: bold; margin-top: 4px; }
        .logo-section .services    { font-size: 10pt; text-decoration: underline; }

        /* ── Numéro ── */
        .numero { font-size: 11pt; margin: 14px 0 20px 0; }

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

        /* ── Corps ── */
        .body-text {
            font-size: 11.5pt;
            line-height: 2;
            text-align: justify;
        }
        .body-text p { margin-bottom: 4px; }

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

        /* ── Signature ── */
        .signature-section {
            margin-top: 28px;
            text-align: center;
        }
        .signature-section .lieu-date  { font-size: 11pt; margin-bottom: 6px; }
        .signature-section .signataire { font-size: 11pt; font-weight: bold; }

        /* ── Ampliations ── */
        .ampliations { margin-top: 50px; font-size: 10pt; }
        .ampliations .titre-ampl { font-weight: bold; text-decoration: underline; margin-bottom: 4px; }
        .ampliations ul { list-style: none; padding-left: 10px; line-height: 1.8; }

        @media print {
            body { padding: 10px 30px; }
            @page { size: A4; margin: 15mm 20mm; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    @php
        $agent      = $sollicitation->agentNonPermanent;
        $commune    = $agent->commune;
        $nomCommune = $commune?->nom_commune ?? 'Kouassi-Kouassikro';

        // Dates
        $dateNaiss = $agent->date_naissance_nopermanent
            ? \Carbon\Carbon::parse($agent->date_naissance_nopermanent)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $datePrise = $agent->date_recrutement_nopermanent
            ? \Carbon\Carbon::parse($agent->date_recrutement_nopermanent)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateDoc = \Carbon\Carbon::now()->locale('fr')->isoFormat('DD MMMM YYYY');

        // Retraite → 60 ans
        $anneeRetraite = $agent->date_naissance_nopermanent
            ? \Carbon\Carbon::parse($agent->date_naissance_nopermanent)->addYears(60)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        // Ancienneté
        $diff = $agent->date_recrutement_nopermanent
            ? \Carbon\Carbon::parse($agent->date_recrutement_nopermanent)->diff(\Carbon\Carbon::now())
            : null;
        $anneesService = $diff
            ? ($diff->y > 0
                ? $diff->y . ' an' . ($diff->y > 1 ? 's' : '') . ' et ' . $diff->m . ' mois'
                : $diff->m . ' mois')
            : '___';

        // CNPS
        $numeroCnps = $agent->numero_cnps_agentnopermanent ?? '_______________';

        // Catégorie / statut
        $categorie = $agent->statut_nopermanent ?? '_______________';
    @endphp

    {{-- ══ EN-TÊTE ══ --}}
    <div class="header">
        <div class="header-left">
            <div>DEPARTEMENT DE {{ Str::upper($nomCommune) }}</div>
            <div class="underline">COMMUNE DE {{ Str::upper($nomCommune) }}</div>
        </div>
        <div class="header-right">
            <div class="bold">REPUBLIQUE DE COTE D'IVOIRE</div>
            <div class="italic">Union-Discipline-Travail</div>
            <div>————————</div>
        </div>
    </div>

    {{-- Logo + Secrétariat --}}
    <div class="logo-section">
        <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo Mairie">
        <div class="secretariat">SECRETARIAT GENERAL</div>
        <div class="services">Services Administratifs</div>
    </div>

    {{-- Numéro --}}
    <div class="numero">
        N° &nbsp;&nbsp;&nbsp;&nbsp; /_____ /COM-KKRO/SG/SA
    </div>

    {{-- ══ TITRE ══ --}}
    <div class="titre">ATTESTATION DE TRAVAIL</div>

    {{-- ══ CORPS ══ --}}
    <div class="body-text">

        <p><strong>Le Maire de la Commune soussigné, atteste que</strong></p>

        <p>
            Matricule
            <span class="field">{{ $agent->numero_act_recrutement_nopermanent ?? '_______________' }}</span>
            , né(e) le
            <span class="field">{{ $dateNaiss }}</span>
            , classé(e) en
            <span class="field">{{ $categorie }}</span>
            , immatriculé(e) à la CNPS sous le n°
            <span class="field">{{ $numeroCnps }}</span>
        </p>

        <p>
            , qui totalise au
            <span class="field">{{ $anneesService }}</span>
            &nbsp; ;
        </p>

        <p>
            Et qui sera appelé(e) à faire valoir ses droits à la retraite pour limite d'âge le
            <span class="field-long">{{ $anneeRetraite }}</span>
            &nbsp; ;
        </p>

        <p>
            Est bénéficiaire d'un Contrat à Durée Indéterminée (CDI) en qualité de
            <span class="field-long">{{ $agent->fonction_nopermanent ?? '_______________' }}</span>
        </p>

        <p>
            à la Mairie de {{ $nomCommune }} depuis le
            <span class="field">{{ $datePrise }}</span>
        </p>

        <p style="margin-top: 14px;">
            En foi de quoi, la présente Attestation est établie pour servir et valoir ce que de droit.
        </p>

    </div>

    {{-- ══ SIGNATURE ══ --}}
    <div class="signature-section">
        <div class="lieu-date">{{ $nomCommune }}, le {{ $dateDoc }}</div>
        <div class="signataire">
            P/Le Maire et {{ $sollicitation->fonction_signataire ?? 'P.D.' }}
        </div>
        <div style="margin-top: 20px; font-size: 11pt;">
            {{ $sollicitation->signataire ?? '' }}
        </div>
    </div>

    {{-- ══ AMPLIATIONS ══ --}}
    <div class="ampliations">
        <div class="titre-ampl">Ampliations</div>
        <ul>
            <li>Intéressé(e)—————————————1</li>
            <li>Dossier——————————————1</li>
            <li>Chrono——————————————1</li>
        </ul>
    </div>

    {{-- Bouton impression --}}
    <div style="text-align:center; margin-top:30px;" class="no-print">
        <button onclick="window.print()"
                style="padding: 10px 30px; background: #0B1F3A; color: white;
                       border: none; border-radius: 8px; font-size: 13px;
                       cursor: pointer; font-family: sans-serif;">
            🖨️ Imprimer ce document
        </button>
    </div>

</body>
</html>