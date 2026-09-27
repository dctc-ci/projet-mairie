<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Congé Paternité - {{ $sollicitation->agent?->nom_prenom_agent ?? $sollicitation->agentNonPermanent?->nom_prenom_nopermanent }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: #000;
            background: #fff;
            padding: 20px 40px;
        }

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

        .logo-section { margin: 10px 0 4px 0; }
        .logo-section img { width: 70px; height: 70px; object-fit: contain; }
        .logo-section .secretariat { font-size: 10pt; font-weight: bold; margin-top: 4px; }
        .logo-section .services    { font-size: 10pt;  }

        .numero { font-size: 11pt; margin: 14px 0 10px 0; }

        /* ── Titre encadré ── */
        .titre-box {
            border: 1.5px solid #000;
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 6px 12px;
            margin-bottom: 18px;
            letter-spacing: 0.5px;
        }

        .body-text {
            font-size: 11.5pt;
            line-height: 2.1;
            text-align: justify;
        }
        .body-text p { margin-bottom: 2px; }

        .field {
            display: inline-block;
            min-width: 100px;
            font-weight: bold;
        }

        .field-sm {
            display: inline-block;
            font-weight: bold;
        }

        .field-long {
            display: inline-block;
            min-width: 220px;
            font-weight: bold;
        }

        /* ── Signature + Ampliations côte à côte ── */
        .footer-wrap {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 24px;
        }

        .ampliations { font-size: 10pt; width: 45%; }
        .ampliations .titre-ampl { font-weight: bold; text-decoration: underline; margin-bottom: 4px; }
        .ampliations ul { list-style: none; padding-left: 0; line-height: 1.8; }

        .signature-section { width: 50%; text-align: center; }
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
        $agent   = $sollicitation->agent;
        $nonPerm = $sollicitation->agentNonPermanent;

        $nom = $agent?->nom_prenom_agent
            ?? $nonPerm?->nom_prenom_nopermanent
            ?? '_______________';

        $matricule = $agent?->matricule
                  ?? $nonPerm?->numero_act_recrutement_nopermanent
                  ?? '_______________';

        $commune    = $agent?->commune ?? $nonPerm?->commune;
        $nomCommune = $commune?->nom_commune ?? 'Kouassi-Kouassikro';

        // Dates
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

        // Jours
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
            <div style="margin-left: 50px;">-----------</div>
            <div class="">COMMUNE DE {{ Str::upper($nomCommune) }}</div>
        </div>
        <div class="header-right">
            <div class="bold">REPUBLIQUE DE COTE D'IVOIRE</div>
            <div class="italic">Union-Discipline-Travail</div>
            <div>------------</div>
        </div>
    </div>

    <div class="logo-section">
        <img src="{{ asset('storage/img/logo-mairie.png') }}" alt="Logo Mairie">
        <div class="secretariat">SECRETARIAT GENERAL</div>
        <div class="services">Services Administratifs</div>
        <div style="margin-left: 50px;">-----------</div>
    </div>

    <div class="numero">
        N° &nbsp;&nbsp;&nbsp;&nbsp; /_____ /COM-KKRO/SG/SA
    </div>

    {{-- ══ TITRE ENCADRÉ ══ --}}
    <div class="titre-box">
        CERTIFICAT DE CESSATION DE SERVICE POUR<br>
        NAISSANCE SURVENUE AU FOYER
    </div>

    {{-- ══ CORPS ══ --}}
    <div class="body-text">

        <p><strong>Le Maire de la Commune de {{ $nomCommune }} soussigné,</strong></p>

        <p><strong>ACCORDE A MONSIEUR</strong></p>

        <p>
            <span class="field-long">{{ $nom }}</span>
        </p>

        <p>
            Matricule
            <span class="field">{{ $matricule }}</span>
        </p>

        <p>
            à la Mairie de {{ $nomCommune }}, une permission exeptionnelle de
            <span class="field-sm">{{ $jours }}</span>
            jours consécutifs à solde de
            présence et non déductibles du congé annuel allant du
            <span class="field">{{ $dateDepart }}</span>
            au
            <span class="field">{{ $dateRetour }}</span>
            inclus.
        </p>

        <p>
            A l'issue de ce congé, l'intéressé reprendra service à son poste le
            <span class="field">{{ $dateReprise }}</span>
            à 7h 30mn.
        </p>

        <p style="margin-top: 14px;">
            En foi de quoi, le présent certificat est établi pour servir et valoir ce que de droit.
        </p>

    </div>

    {{-- ══ FOOTER : Ampliations + Signature côte à côte ══ --}}
    <div class="footer-wrap">

        <div class="ampliations">
            <div class="titre-ampl">Ampliations</div>
            <ul>
                <li>SG———————————————1</li>
                <li>Chefs de sces—————————1</li>
                <li>Dossier———————————————1</li>
                <li>Chrono————————————————1</li>
            </ul>
        </div>

        <div class="signature-section">
            <div class="lieu-date">{{ $nomCommune }}, le {{ $dateDoc }}</div>
            <div class="signataire">
                P/Le Maire et {{ $sollicitation->fonction_signataire ?? 'PD' }}
            </div>
            <div style="margin-top: 10px; font-size: 11pt;">
                {{ $sollicitation->signataire ?? '' }}
            </div>
        </div>

    </div>

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