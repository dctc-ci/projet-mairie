<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ordre de Mission - {{ $sollicitation->agent?->nom_prenom_agent ?? $sollicitation->agentNonPermanent?->nom_prenom_nopermanent }}</title>
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
        .header-wrap {
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

        /* ── Logo + titre rangée ── */
        .logo-titre-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin: 10px 0 8px 0;
        }

        .logo-section img { width: 70px; height: 70px; object-fit: contain; }
        .logo-section .secretariat { font-size: 10pt; font-weight: bold; margin-top: 4px; }
        .logo-section .services    { font-size: 10pt; }

        /* ── Titre ORDRE DE MISSION ── */
        .titre-ordre {
            font-size: 15pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: right;
        }

        /* ── Numéro ── */
        .numero { font-size: 11pt; margin: 6px 0 12px 0; }

        /* ── Grand cadre principal ── */
        .cadre-principal {
            border: 2px solid #000;
        }

        /* Section intérieure avec bordures */
        .section {
            padding: 10px 20px;
            border-bottom: 1.5px solid #000;
        }
        .section:last-child { border-bottom: none; }

        /* Titre MAIRE */
        .titre-maire {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        /* Ligne champ */
        .row {
            display: flex;
            align-items: baseline;
            margin-bottom: 4px;
            font-size: 11.5pt;
            line-height: 1.9;
        }

        .row-label {
            font-weight: bold;
            white-space: nowrap;
            min-width: 220px;
            text-align: right;
            padding-right: 8px;
        }

        .row-value {
            flex: 1;
            border-bottom: 1px solid #000;
            min-height: 20px;
            font-weight: bold;
            padding-left: 4px;
        }

        /* Section signature */
        .section-signature {
            padding: 16px 20px;
            text-align: center;
        }
        .lieu-date  { font-size: 11pt; margin-bottom: 6px; }
        .signataire { font-size: 11pt; font-weight: bold; }

        @media print {
            body { padding: 10px 30px; }
            @page { size: A4; margin: 15mm 20mm; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    @php
        $agent   = $sollicitation->agent;
        $nonPerm = $sollicitation->agentNonPermanent;

        $nom = $agent?->nom_prenom_agent
            ?? $nonPerm?->nom_prenom_nopermanent
            ?? '_______________';

        $groupe   = $agent?->groupe
                 ?? '_______________';

        $indice   = $agent?->baremeSalarial?->indice
                 ?? '_______________';

        $fonction = $agent?->fonction
                 ?? $nonPerm?->fonction_nopermanent
                 ?? '_______________';

        $commune    = $agent?->commune ?? $nonPerm?->commune;
        $nomCommune = $commune?->nom_commune ?? 'Kouassi-Kouassikro';

        $imputBudget = $agent?->imputa_budgetaire
                    ?? '_______________';

        // Dates
        $dateDepart = $sollicitation->date_depart
            ? \Carbon\Carbon::parse($sollicitation->date_depart)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateRetour = $sollicitation->date_retour
            ? \Carbon\Carbon::parse($sollicitation->date_retour)->locale('fr')->isoFormat('DD MMMM YYYY')
            : '_______________';

        $dateDoc = \Carbon\Carbon::now()->locale('fr')->isoFormat('DD MMMM YYYY');
    @endphp

    {{-- ══ EN-TÊTE ══ --}}
    <div class="header-wrap">
        <div class="header-left">
            <div>DEPARTEMENT DE {{ Str::upper($nomCommune) }}</div>
            <div style="margin-left: 50px;">-----------</div>
            <div class="">COMMUNE DE {{ Str::upper($nomCommune) }}</div>
        </div>
        <div class="header-right">
            <div class="bold">REPUBLIQUE DE COTE D'IVOIRE</div>
            <div class="italic">Union-Discipline-Travail</div>
            <div>------------</div>
        </div>
    </div>

    {{-- Logo + Titre côte à côte --}}
    <div class="logo-titre-row">
        <div class="logo-section">
            <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo Mairie">
            <div class="secretariat">SECRETARIAT GENERAL</div>
            <div class="services">Services Administratifs</div>
            <div style="margin-left: 50px;">-----------</div>
        </div>
        <div class="titre-ordre">ORDRE DE MISSION</div>
    </div>

    {{-- Numéro --}}
    <div class="numero">
        N° &nbsp;&nbsp;&nbsp;&nbsp; /_____ /COM-KKRO/SG/SA
    </div>

    {{-- ══ GRAND CADRE ══ --}}
    <div class="">

        {{-- Section 1 : Ordre --}}
        <div class="section">
            <div class="titre-maire">
                LE MAIRE DE LA COMMUNE DE {{ Str::upper($nomCommune) }}
            </div>

            <div class="row">
                <span class="row-label">DONNE L'ORDRE A :</span>
                <span class="row-value">{{ $nom }}</span>
            </div>
            <div class="row">
                <span class="row-label">GROUPE :</span>
                <span class="row-value">{{ $groupe }}</span>
            </div>
            <div class="row">
                <span class="row-label">INDICE :</span>
                <span class="row-value">{{ $indice }}</span>
            </div>
            <div class="row">
                <span class="row-label">EXERCANT LA FONCTION DE :</span>
                <span class="row-value">{{ $fonction }}</span>
            </div>
            <div class="row">
                <span class="row-label">DE SE RENDRE A :</span>
                <span class="row-value">{{ $sollicitation->destination ?? '_______________' }}</span>
            </div>
        </div>

        {{-- Section 2 : Objet --}}
        <div class="section">
            <div class="row">
                <span class="row-label">OBJET DE LA MISSION :</span>
                <span class="row-value">{{ $sollicitation->motif_sollicitation ?? '_______________' }}</span>
            </div>
        </div>

        {{-- Section 3 : Dates + Transport --}}
        <div class="section">
            <div class="row">
                <span class="row-label">DATE DE DEPART :</span>
                <span class="row-value">{{ $dateDepart }}</span>
            </div>
            <div class="row">
                <span class="row-label">DATE DE RETOUR :</span>
                <span class="row-value">{{ $dateRetour }}</span>
            </div>
            <div class="row">
                <span class="row-label">MOYEN DE TRANSPORT :</span>
                <span class="row-value" style="font-weight:bold;">VEHICULE EN COMMUN</span>
            </div>
            <div class="row">
                <span class="row-label">IMPUTATION BUDGETAIRE :</span>
                <span class="row-value">{{ $imputBudget }}</span>
            </div>
        </div>

        {{-- Section 4 : Signature --}}
        <div class="section-signature">
            <div class="lieu-date">{{ $nomCommune }}, le {{ $dateDoc }}</div>
            <div class="signataire">
                P/Le Maire et {{ $sollicitation->fonction_signataire ?? 'PD.' }}
            </div>
            <div style="margin-top: 50px; font-size: 11pt;">
                {{ $sollicitation->signataire ?? '' }}
            </div>
        </div>

    </div>{{-- fin cadre --}}

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