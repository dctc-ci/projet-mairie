<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autorisation d'Absence - {{ $sollicitation->agent->nom_prenom_agent ?? $sollicitation->agentNonPermanent?->nom_prenom_nopermanent }}</title>
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

        .header-left {
            font-size: 10pt;
            font-weight: bold;
            line-height: 1.6;
        }

        .header-left .underline { text-decoration: underline; }

        .header-right {
            font-size: 10pt;
            text-align: right;
            line-height: 1.6;
        }

        .header-right .bold   { font-weight: bold; }
        .header-right .italic { font-style: italic; }

        /* ── Logo ── */
        .logo-section { margin: 10px 0 4px 0; }
        .logo-section img { width: 70px; height: 70px; object-fit: contain; }
        .logo-section .secretariat { font-size: 10pt; font-weight: bold; margin-top: 4px; }
        .logo-section .services    { font-size: 10pt; }

        /* ── Numéro ── */
        .numero { font-size: 11pt; margin: 14px 0 20px 0; }

        /* ── Titre ── */
        .titre {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        /* ── Corps ── */
        .body-text {
            font-size: 11.5pt;
            line-height: 1.9;
            text-align: justify;
        }

        .body-text p { margin-bottom: 4px; }

        .autorise {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            letter-spacing: 3px;
            margin: 16px 0 14px 0;
        }

        /* Lignes de champ */
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

        /* Bloc indenté pour les champs AUTORISE */
        .indent-block {
            padding-left: 60px;
            line-height: 2;
        }

        .indent-block .row {
            display: flex;
            align-items: baseline;
            gap: 6px;
            margin-bottom: 2px;
        }

        .indent-block .label {
            min-width: 160px;
            text-align: right;
            flex-shrink: 0;
        }

        /* ── Signature ── */
        .signature-section {
            margin-top: 24px;
            text-align: center;
        }

        .signature-section .lieu-date  { font-size: 11pt; margin-bottom: 6px; }
        .signature-section .signataire { font-size: 11pt; font-weight: bold; }

        @media print {
            body { padding: 10px 30px; }
            @page { size: A4; margin: 15mm 20mm; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    @php
        // ── Déterminer le personnel concerné ──────────────────
        $agent    = $sollicitation->agent;
        $nonPerm  = $sollicitation->agentNonPermanent;
        $stagiaire= $sollicitation->stagiaire;

        $nom      = $agent?->nom_prenom_agent
                 ?? $nonPerm?->nom_prenom_nopermanent
                 ?? $stagiaire?->nom_prenom_stagiaire
                 ?? '_______________';

        $fonction = $agent?->fonction
                 ?? $nonPerm?->fonction_nopermanent
                 ?? '_______________';

        $service  = $agent?->service
                 ?? $nonPerm?->service_nopermanent
                 ?? '_______________';

        $commune  = $agent?->commune
                 ?? $nonPerm?->commune
                 ?? null;

        $nomCommune = $commune?->nom_commune ?? 'Nom de la Commune';

        // ── Dates ───────────────────────────────────────────────
        $dateSollicitation = $sollicitation->date_sollicitation
            ? \Carbon\Carbon::parse($sollicitation->date_sollicitation)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateDepart = $sollicitation->date_depart
            ? \Carbon\Carbon::parse($sollicitation->date_depart)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateRetour = $sollicitation->date_retour
            ? \Carbon\Carbon::parse($sollicitation->date_retour)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateReprise = $sollicitation->date_reprise
            ? \Carbon\Carbon::parse($sollicitation->date_reprise)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateDoc = \Carbon\Carbon::now()->locale('fr')->isoFormat('DD MMMM YYYY');

        // ── Jours ───────────────────────────────────────────────
       $jours = $sollicitation->jours_sollicite > 0
    ? $sollicitation->jours_sollicite
    : ($sollicitation->date_depart && $sollicitation->date_retour
        ? \Carbon\Carbon::parse($sollicitation->date_depart)
              ->diffInDays(\Carbon\Carbon::parse($sollicitation->date_retour))
        : '___');
    @endphp

    {{-- ══ EN-TÊTE ══ --}}
    <div class="header">
        <div class="header-left">
            <div>DEPARTEMENT DE {{ Str::upper($nomCommune) }}</div>
            <div style="margin-left: 50px;">---------------</div>
            <div class="">COMMUNE DE {{ Str::upper($nomCommune) }}</div>
        </div>
        <div class="header-right">
            <div class="bold">REPUBLIQUE DE COTE D'IVOIRE</div>
            <div class="italic">Union-Discipline-Travail</div>
            <div>---------------</div>
        </div>
    </div>

    {{-- Logo + Secrétariat --}}
    <div class="logo-section">
        <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo Mairie">
        <div class="secretariat">SECRETARIAT GENERAL</div>
        <div class="services">Services Administratifs</div>
        <div class="services">----------------------------</div>
    </div>

    {{-- Numéro --}}
    <div class="numero">
        N° &nbsp;&nbsp;&nbsp;&nbsp; /_____ /COM-KKRO/SG/SA
    </div>

    {{-- ══ TITRE ══ --}}
    <div class="titre">AUTORISATION D'ABSENCE</div>

    {{-- ══ CORPS ══ --}}
    <div class="body-text">

        <p><strong>Le Maire de la Commune de {{ $nomCommune }} ;</strong></p>

        <p>
            Vu la Demande d'autorisation d'absence formulée par l'intéressé(e) en date du
            <span class="field">{{ $dateSollicitation }}</span>
            et considérant le caractère fondé de la sollicitation,
        </p>

        <div class="autorise">A U T O R I S E</div>

        <div class="indent-block">
            <div class="row">
                <span class="label">Nom et Prénoms :</span>
                <span class="field-long">{{ $nom }}</span>
            </div>
            <div class="row">
                <span class="label">Fonction :</span>
                <span class="field-long">{{ $fonction }}</span>
            </div>
            <div class="row">
                <span class="label">Services :</span>
                <span class="field-long">{{ $service }}</span>
            </div>
            <div class="row">
                <span class="label">A s'absenter de son poste du :</span>
                <span class="field">{{ $dateDepart }}</span>
                &nbsp; AU &nbsp;
                <span class="field">{{ $dateRetour }}</span>
            </div>
            <div class="row">
                <span class="label">Motif de l'absence :</span>
                <span class="field-long">{{ $sollicitation->motif_sollicitation ?? '_______________' }}</span>
            </div>
            <div class="row">
                <span class="label">Destination :</span>
                <span class="field-long">{{ $sollicitation->destination ?? '_______________' }}</span>
            </div>
        </div>

        <p style="margin-top: 14px;">
            Au terme de cette absence de
            <span class="field">{{ $jours }}</span>
            jour(s), l'intéressé(e) reprendra service à son poste habituel
        </p>

        <p>
            le
            <span class="field">{{ $dateReprise }}</span>
            aux heures habituelles sauf cas de dispositions contraires avérées
        </p>

    </div>

    {{-- ══ SIGNATURE ══ --}}
    <div class="signature-section">
        <div class="lieu-date">{{ $nomCommune }}, le {{ $dateDoc }}</div>
        <div class="signataire">
             {{ $sollicitation->fonction_signataire ?? 'PO' }}
        </div>
        <div style="margin-top: 30px; font-size: 11pt;">
            {{ $sollicitation->signataire ?? '' }}
        </div>
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